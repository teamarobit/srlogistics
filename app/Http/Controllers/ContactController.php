<?php
  
namespace App\Http\Controllers;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Gsttreat;
use App\Models\Cotype;
use App\Models\Contact;
use App\Models\User;

use App\Models\Contactrole;
use App\Models\Customerabouttype;
use App\Models\Coattachtype;
use App\Models\Coattachment;
use App\Models\Relcontact;
use App\Models\Cobilling;
use App\Models\Coaddress;
use App\Models\Customerlocation;
use App\Models\Contracttype;
use App\Models\Customercontract;
use App\Models\Customercontractdetail;
use App\Models\Contactbank;
use App\Models\Contractroute;
use App\Models\Loadvendorlocation;
use App\Models\Vehicleallocation;

use App\Models\Employeeasset;
use App\Models\Employeeallotedassetlog;

use App\Models\Employeeworkexperience;
use App\Models\Employeesalary;

use App\Models\Employeeexitdetail;

use App\Models\Contractpricing;
use App\Models\Contractpricinglocationpoint;
use App\Models\Contractpricingvehicle;
use App\Models\Contractpricinglog;
use App\Models\Contractpricinglocationpointlog;
use App\Models\Contractpricingvehiclelog;


use App\Models\Branch;
use App\Models\Religion;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Role;
use App\Models\Jobrank;
use App\Models\Skillset;
use App\Models\Bank;
use App\Models\Route;
use App\Models\Routemidpoint;
use App\Models\Vehicletype;
use App\Models\Vehicletypesize;
use App\Models\Asset;
use App\Models\Vehicleownership;
use App\Models\Panstatus;
use App\Models\Driverinfo;
use App\Models\Drivervehiclephoto;
use App\Models\Contactactivity;
use App\Models\Vehicle;
use App\Models\Tyre;
use App\Models\WsSparePartCategory;

use App\Models\Actmodel;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Hash;
use Auth;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Closure;
use Illuminate\Support\Fluent;
use Illuminate\Database\Eloquent\Builder;

use App\Traits\Useractivity;


class ContactController extends Controller
{
    
    use Useractivity;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    const CONTACT_TYPE_CUSTOMER         = 1;
    const CONTACT_TYPE_LOAD_VENDOR      = 2; 
    const CONTACT_TYPE_EMPLOYEE         = 3;
    const CONTACT_TYPE_DRIVER           = 4;
    const CONTACT_TYPE_VEHICLE_VENDOR   = 5;  
    const CONTACT_TYPE_TYRE_VENDOR      = 6;  
    const CONTACT_TYPE_BATTERY_VENDOR   = 7;
    const CONTACT_TYPE_SPARE_VENDOR     = 8;
    const CONTACT_TYPE_INSURANCE_PROVIDER = 9;
    
    public function index(Request $request): View
    {
        
        $contacts = Contact::query();
        
        $cotype     = $request->get('cotype');   //echo "qq ".$cotype; exit();
        $contactid  = $request->query('contact');
        $name       = $request->query('name');
        $phone      = $request->query('phone');
        
        if ( $contactid ) {
            $contacts->where('id', $contactid );
            $name   = null; 
        }else {
            if( $name ) {
                $contacts->where('contact_name','like','%'.$name.'%');
            }
            
            if( $phone ) {
                $contacts->where('phone','like','%'.$phone.'%');
            }
        }
        
        if($cotype != ''){
            $contacts = $contacts->whereHas('cotype', function($query) use($cotype){
                $query->where('slug', $cotype);
            });
        }
        
        $contacts = $contacts->with('cotype')->orderBy('id', 'desc')->paginate(10);
        
        // If cotype is not present in query, try to derive it from the first contact
        // if (!$cotype && $contacts->count()) {
        //     $firstContact = $contacts->first();
        //     if ($firstContact->cotype) {
        //         $cotype = $firstContact->cotype->slug; // or ->id if needed
        //     }
        // }
        
        return view('contacts.index',compact('contacts','contactid', 'name', 'phone', 'cotype'));
    }
    
    
    public function deleteSelected(Request $request)
    {
        try {
    
            $ids = $request->input('ids');
    
            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'data' => [],
                    'message' => 'No records selected.'
                ]);
            }
    
            DB::transaction(function () use ($ids) {
    
                $contacts = Contact::with('cotype', 'customercontracts')->whereIn('id', $ids)->get();
    
                foreach ($contacts as $contact) {

                    if ($contact->customercontracts->isNotEmpty()) {

                        \Log::warning('Delete blocked - customer contracts exist', [
                            'contact_id' => $contact->id
                        ]);

                        throw new \Exception("Cannot delete contact ID {$contact->id}. Customer contracts exist.");
                    }
    
                    $cotypeName = $contact->cotype ? $contact->cotype->name : null;
                    $actmodelId = null;
    
                    if ($cotypeName) {
                        $actmodel = Actmodel::where('name', $cotypeName)->first();
                        if ($actmodel) {
                            $actmodelId = $actmodel->id;
                        }
                    }
    
                    $contact->delete();
    
                    $description = 'Deleted a contact.';
                    $this->storeUseractivity($actmodelId, 6, Auth::user()->id, $contact->id, $description);
                }
            });
    
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'Selected records deleted successfully.'
            ]);
    
        } catch (\Exception $e) {
    
            \Log::error('Delete Selected Contacts Error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
    
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => $e->getMessage()
            ]);
        }
    }
    
    
    public function deleteAll(Request $request)
    {
        try {
    
            $cotypeSlug  = $request->input('cotype');
            $search_name = $request->input('name');
            $search_city = $request->input('city');
            $search_size = $request->input('size');
            $search_location = $request->input('location');
            $search_rag      = $request->input('rag');
            $search_branch = $request->branch;
            $search_worktype = $request->worktype;
            $search_category = $request->category;
    
            if (!$cotypeSlug) {
                return response()->json([
                    'success' => false,
                    'data' => [],
                    'message' => 'Contact type not provided.'
                ]);
            }
    
            $cotype = Cotype::where('slug', $cotypeSlug)->first();
    
            if (!$cotype) {
                return response()->json([
                    'success' => false,
                    'data' => [],
                    'message' => 'Invalid contact type.'
                ]);
            }
    
            DB::transaction(function () use ($request, &$cotype) {
    
                $query = Contact::with('customercontracts')->where('cotype_id', $cotype->id);
    
                // Apply filters
                if (!empty($request->name)) {
                    $query->where('contact_name', 'like', '%' . $request->name . '%');
                }
    
                if (!empty($request->city)) {
                    $query->where('city_id', $request->city);
                }
    
                if (!empty($request->size)) {
                    $query->where('size', $request->size);
                }
                
                if (!empty($request->branch)) {
                    $query->where(function ($q) use ($request) {
                        $q->where('office_branch_id', $request->branch)
                          ->orWhere('service_center_branch_id', $request->branch);
                    });
                }
        
                if (!empty($request->worktype)) {
                    $query->where('work_type', $request->worktype);
                }
                
                if (!empty($request->category)) {
                    $query->whereHas('driverinfo', function ($q) use ($request) {
                        $q->where('category', $request->category);
                    });
                }
                
                
                if (!empty($request->rag)) {
                    $query->where('rag_status', $request->rag);
                }
                
                if (!empty($request->location)) {
                    $query->whereHas('loadvendorlocations', function ($q) use ($request) {
                        $q->where('id', $request->location);
                    });
                }
    
                $contacts = $query->get();
    
                $actmodel = Actmodel::where('name', $cotype->name)->first();
                $actmodelId = $actmodel ? $actmodel->id : null;
    
                foreach ($contacts as $contact) {

                    if ($contact->customercontracts->isNotEmpty()) {

                        \Log::warning('Delete blocked - customer contracts exist', [
                            'contact_id' => $contact->id
                        ]);

                        throw new \Exception("Cannot delete contact ID {$contact->id}. Customer contracts exist.");
                    }
    
                    $contact->delete();
    
                    $description = 'Deleted a contact.';
                    $this->storeUseractivity($actmodelId, 6, Auth::id(), $contact->id, $description);
                }
    
            });
    
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'Filtered '.$cotype->name.' records deleted successfully.'
            ]);
    
        } catch (\Exception $e) {
    
            \Log::error('Delete All Contacts Error', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile()
            ]);
    
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Something went wrong while deleting records.'
            ]);
        }
    }
    
    
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        
        if (empty($id)) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
    
        $contact = Contact::with('cotype')->find($id);
    
        if (!$contact) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Contact not found.']);
        }
        


        $cotypeName = $contact->cotype ? $contact->cotype->name : null;
        $actmodelId = null;
        if ($cotypeName) {
            $actmodel = Actmodel::where('name', $cotypeName)->first();
        
            if ($actmodel) {
                $actmodelId = $actmodel->id;
            }
        }
        
        $actmodelid = $request->input('actmodelid') ?? $actmodelId;
        
        \Log::info('Actmodel Debug', [
            'request_actmodelid' => $request->input('actmodelid'),
            'fallback_actmodelId' => $actmodelId,
            'final_actmodelid' => $actmodelid,
        ]);
    
    
        // Check if this contact is associated with any SalesOrder
        // $hasSO = SalesOrder::where('customer_id', $id)->exists();
        // if ($hasSO) {
        //     return response()->json([
        //         'success' => false, 
        //         'data' => [], 
        //         'message' => 'This contact is associated with a Sales Order and cannot be deleted.'
        //     ]);
        // }
        
    
        // Proceed with delete inside transaction
        DB::transaction(function () use ($contact, $actmodelid) {
            $contact->delete(); // delete contact
    
            // Log activity
            $description = 'Deleted a contact.';
            $this->storeUseractivity($actmodelid, 6, Auth::user()->id, $contact->id, $description);
        });
    
        return response()->json(['success' => true, 'data' => [], 'message' => 'Record deleted successfully.']);
    }
    
    
    public function storeActivityNotes(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'activity_notes' => 'required|string',
            'contact_id'     => 'required|exists:contacts,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }
    
        
    
        try {
            
            $activity = null;
            
            DB::transaction(function () use ($request, &$activity) {
                
                $activity = new Contactactivity();
                $activity->contact_id = $request->contact_id;
                $activity->notes = $request->activity_notes;
                $activity->created_by = Auth::user()->id;
                $activity->save();
                
                // Log user activity
                //$this->storeUseractivity(42, 3, Auth::user()->id, $tollstation->id, 'Added new Toll Station.');
            });
            
            $success = true;
            $respmessage = 'Activity note saved successfully.';
    
    
        } catch (\Exception $exp) {
            
            // \Log::error('Process save error', [
            //     'message' => $exp->getMessage(),
            //     'trace' => $exp->getTraceAsString()
            // ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $activity, 'message' => $respmessage]);
    }

    
    
    // For Dropzone ----------------------------------------------------------------------------------------------------------
    public function attachmentWrapper(Request $request)
    {
        $coattachtypes = Coattachtype::all();
        
        $rowindex = $request->get('rowindex');
        
        if($request->form_type == 'Add'){
            $html = view('contacts.attachment-wrapper.add', compact('coattachtypes', 'rowindex'))->render(); 
        }else{
            
            $html = view('contacts.attachment-wrapper.edit', compact('coattachtypes', 'rowindex'))->render();
        }
        
        return response()->json(['success' => true, 'data' => ['formelements' => $html, 'rowindex' => $rowindex], 'message' => 'Contact Person wrapper fetched']);
    }
    
    
    public function updateAttachment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'attachment_id'   => 'required|exists:coattachments,id',
            'attachment_file' => 'required|file'
        ]);
        
        if ($validator->fails()) {
            //\Log::error('Validation failed', [
                //'errors' => $validator->errors()->toArray(),
                //'location_type' => $request->location_type,
               // 'input' => request()->all(), // optional: log the input data for context
            //]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.'
            ], 422);
        }
        
        try {
            
            DB::transaction(function () use ($request) {
                
                $attachment = Coattachment::find($request->attachment_id);
    
                if ($request->hasFile('attachment_file')) {
    
                    // delete old file
                    $oldFile = public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR.$attachment->name);
            
                    if (File::exists($oldFile)) {
                        //File::delete($oldFile);
                    }
            
                    $file = $request->file('attachment_file');
            
                    $fileoriginalname = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $filesize = $file->getSize();
                    
            
                    // Keep original extension
                    $filename = 'contact-attachment-'.Str::random(4).'_'.time().'.'.$extension;

                    $file->move(
                        public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR),
                        $filename
                    );
    
                    $attachment->name          = $filename;
                    $attachment->original_name = $fileoriginalname;
                    $attachment->file_size     = ($filesize/(1024*1024));
                    $attachment->updated_by    = auth()->id();
                    $attachment->save();
                }
                
            });
    
            return response()->json([
                'success' => true,
                'data'    => [],
                'message' => 'Attachment saved successfully.'
            ]);
            
        } catch (\Throwable $e) {

            \Log::error('Save failed', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
        
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $e->getMessage(),
            ], 500);
        }
        
    }
    
    
    public function deleteAttachment($id)
    {
        if($id == ''){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
        
        $contactattachment =  Coattachment::find($id); 
        if($contactattachment == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! attachment not found.']);
        }
        
        /*if(File::exists(public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR.$contactattachment->name))){
            File::delete(public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR.$contactattachment->name));
        }*/
        $contactattachment->delete();
        
        return response()->json(['success' => true, 'data' => [], 'message' => 'Attachment deleted successfully.']);
    }
    // For Dropzone ----------------------------------------------------------------------------------------------------------
    
    
    
    
    
    
    // Other Functions -------------------------------------------------------------------------------------------------------
    public function customer_contactPersonWrapper(Request $request)
    {
        $rowindex = $request->get('rowindex');
        
        $html = view('contacts.contact-person-wrapper.customer-contact-person', compact('rowindex'))->render();
        
        return response()->json(['success' => true, 'data' => $html, 'message' => 'Customer contact person wrapper fetched']);
    }
    
    
    public function employee_emergency_contact_wrapper(Request $request)
    {
        $rowindex = $request->get('rowindex');
        
        $html = view('contacts.contact-person-wrapper.employee-emergency-contact', compact('rowindex'))->render();
        
        return response()->json(['success' => true, 'data' => $html, 'message' => 'Employee emergency contact wrapper fetched']);
    }
    
    
    public function loadvendor_contactPersonWrapper(Request $request)
    {
        $rowindex = $request->get('rowindex');
        
        //\Log::info('Row Index:', ['rowindex' => $rowindex]);
        
        $html = view('contacts.contact-person-wrapper.loadvendor-contact-person', compact('rowindex'))->render();
        
        return response()->json(['success' => true, 'data' => $html, 'message' => 'Loadvendor contact person wrapper fetched.']);
    }
    
    
    public function vehiclevendor_contactPersonWrapper(Request $request)
    {
        $rowindex = $request->get('rowindex');
        
        //\Log::info('Row Index:', ['rowindex' => $rowindex]);
        
        $html = view('contacts.contact-person-wrapper.vehiclevendor-contact-person', compact('rowindex'))->render();
        
        return response()->json(['success' => true, 'data' => $html, 'message' => 'Vehiclevendor contact person wrapper fetched.']);
    }
    
    public function tyrevendor_contactPersonWrapper(Request $request)
    {
        $rowindex = $request->get('rowindex');
        
        //\Log::info('Row Index:', ['rowindex' => $rowindex]);
        
        $html = view('contacts.contact-person-wrapper.tyrevendor-contact-person', compact('rowindex'))->render();
        
        return response()->json(['success' => true, 'data' => $html, 'message' => 'Tyrevendor contact person wrapper fetched.']);
    }
    
    public function batteryvendor_contactPersonWrapper(Request $request)
    {
        $rowindex = $request->get('rowindex');
        
        //\Log::info('Row Index:', ['rowindex' => $rowindex]);
        
        $html = view('contacts.contact-person-wrapper.batteryvendor-contact-person', compact('rowindex'))->render();
        
        return response()->json(['success' => true, 'data' => $html, 'message' => 'Tyrevendor contact person wrapper fetched.']);
    }
    
    
    public function driver_emergency_contact_wrapper(Request $request)
    {
        $rowindex = $request->get('rowindex');
        
        //\Log::info('Row Index:', ['rowindex' => $rowindex]);
        
        $html = view('contacts.contact-person-wrapper.driver-emergency-contact', compact('rowindex'))->render();
        
        return response()->json(['success' => true, 'data' => $html, 'message' => 'Driver emergency contact person wrapper fetched.']);
    }
    
    public function driver_bankWrapper(Request $request)
    {
        $rowindex = $request->get('rowindex');
        
        $banks = Bank::orderBy('name')->get();
        
        //\Log::info('Row Index:', ['rowindex' => $rowindex]);
        
        $html = view('contacts.contact-bank-detail-wrapper.driver-bank-detail', compact('rowindex','banks'))->render();
        
        return response()->json(['success' => true, 'data' => $html, 'message' => 'Vehiclevendor bank detail wrapper fetched.']);
    }
    
    
    public function vehiclevendor_bankWrapper(Request $request)
    {
        $rowindex = $request->get('rowindex');
        
        $banks = Bank::orderBy('name')->get();
        
        //\Log::info('Row Index:', ['rowindex' => $rowindex]);
        
        $html = view('contacts.contact-bank-detail-wrapper.vehiclevendor-bank-detail', compact('rowindex','banks'))->render();
        
        return response()->json(['success' => true, 'data' => $html, 'message' => 'Vehiclevendor bank detail wrapper fetched.']);
    }
    
    
    public function tyrevendor_bankWrapper(Request $request)
    {
        $rowindex = $request->get('rowindex');
        
        $banks = Bank::orderBy('name')->get();
        
        //\Log::info('Row Index:', ['rowindex' => $rowindex]);
        
        $html = view('contacts.contact-bank-detail-wrapper.tyrevendor-bank-detail', compact('rowindex','banks'))->render();
        
        return response()->json(['success' => true, 'data' => $html, 'message' => 'Tyre vendor bank detail wrapper fetched.']);
    }
    
    
    public function batteryvendor_bankWrapper(Request $request)
    {
        $rowindex = $request->get('rowindex');
        
        $banks = Bank::orderBy('name')->get();
        
        //\Log::info('Row Index:', ['rowindex' => $rowindex]);
        
        $html = view('contacts.contact-bank-detail-wrapper.batteryvendor-bank-detail', compact('rowindex','banks'))->render();
        
        return response()->json(['success' => true, 'data' => $html, 'message' => 'Battery vendor bank detail wrapper fetched.']);
    }
    
    
    
    // Customer Section ------------------------------------------------------------------------------------------------------
    
    public function customerList(Request $request): View
    {
        $cotypeId = self::CONTACT_TYPE_CUSTOMER;
        //$organisationId = organisation_id();
        
        
        // Filter 
        $search_name = $request->name;
        $search_city = $request->city;
        $search_size = $request->size;
        
        $contacts = Contact::query()->where('cotype_id', $cotypeId);

        // Filter by name
        if ($request->filled('name')) {
            $contacts->where('contact_name', 'like', '%' . $request->name . '%');
        }
        
        // Filter by city 
        if ($request->filled('city')) {
            $contacts->where(function ($q) use ($request) {
                $q->where('city_id', $request->city);
            });
        }
        
        // Filter by size
        if ($request->filled('size')) {
            $contacts->where('size', $request->size);
        }
        
    
        // $contacts = $contacts::where('organisation_id', $organisationId)
        //                     ->with(['cotype', 'customerlocations'])
        //                     ->orderBy('id', 'desc')
        //                     ->paginate(10)
        //                     ->withQueryString(); // keep filters while paginating
        
        $contacts = $contacts
                            ->with(['cotype', 'customerlocations'])
                            ->orderBy('id', 'desc')
                            ->paginate(10)
                            ->withQueryString();
        
        
        $cotypes   = Cotype::all();
        $cotype        = $cotypes->firstWhere('id', self::CONTACT_TYPE_CUSTOMER);
        
        $cities = City::whereHas('state.country', function ($q) {
                            $q->where('iso2', 'IN');   
                        })->orderBy('name')->get();
                        
        
        //dd($contacts);
        
        
        return view('contacts.customer.index', compact('contacts','cities','cotype','search_name','search_city','search_size')); 
       
    }
    
    
    public function createCustomer(Request $request){
        
        $countries = Country::all();
        
        $states = State::whereHas('country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
                        
                        
        $cotypes   = Cotype::all();
        $customerabouttype = Customerabouttype::orderBy('name')->get();
        
        $gsttreats = Gsttreat::all();
        $coattachtypes = Coattachtype::all();       
        $cotype        = $cotypes->firstWhere('id', self::CONTACT_TYPE_CUSTOMER);
        
        return view('contacts.customer.create',compact('customerabouttype','countries','states','cotype','cotypes','gsttreats','coattachtypes')); 
    }
    
    
    public function storeCustomer(Request $request) { 
        
        $request->merge([
            'phone'    => preg_replace('/\s+/', '', $request->phone),
            'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp),
            'is_deduction_chargeable' => $request->is_deduction_chargeable == 1 ? 1 : 0,
            
            'contact_person_name'      => array_values($request->contact_person_name ?? []),
            'contact_person_phone'     => array_values($request->contact_person_phone ?? []),
            'contact_person_whatsapp'  => array_values($request->contact_person_whatsapp ?? []),
            'contact_person_email'     => array_values($request->contact_person_email ?? []),
            'contact_person_designation' => array_values($request->contact_person_designation ?? []),
            'contact_person_comment'   => array_values($request->contact_person_comment ?? []),
        ]);
        
        // Clean contact person phones
        if ($request->has('contact_person_phone')) {
            $phones = $request->contact_person_phone;
        
            foreach ($phones as $k => $p) {
                $phones[$k] = preg_replace('/\s+/', '', $p);
            }
        
            $request->merge(['contact_person_phone' => $phones]);
        }
        
        // Clean contact person whatsapp
        if ($request->has('contact_person_whatsapp')) {
            $whatsapps = $request->contact_person_whatsapp;
        
            foreach ($whatsapps as $k => $w) {
                $whatsapps[$k] = preg_replace('/\s+/', '', $w);
            }
        
            $request->merge(['contact_person_whatsapp' => $whatsapps]);
        }


        $validate_phone = function ($attribute, $value, $fail) use ($request) {
            $code = $request->phone_code ?? getPhoneCode();
        
            if (!$code) {
                //$fail('Phone number required country code to be selected.');
            }
        
            if (Contact::where('phone', $value)->where('ph_prefix', $code)->exists()) {
                $fail('This phone number already exists.');
            }
        };
        
        $validate_whatsapp = function ($attribute, $value, $fail) use ($request) {
            if (!$value) return;
        
            $code = $request->whatsapp_code ?? getPhoneCode();
        
            if (!$code) {
                //$fail('WhatsApp number required country code to be selected.');
            }
            
            if (Contact::where('whatsapp', $value)->where('whatsapp_prefix', $code)->exists()) {
                $fail('This whatsapp number already exists.');
            }
        };

        
        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) use ($request) {
            $index = explode('.', $attribute)[1] ?? null;
            $code = $request->get('contact_person_ph_code')[$index];
            if($code === NULL){
                //$fail('Phone number required country code to be selected.');
            }
        };
        
        $validator = Validator::make($request->all(), [
            'gst_number'          => 'required|max:100',
            'contact_name'        => 'required|max:100',
            'about_type_id'       => 'required|exists:customerabouttypes,id',
            'size'                => 'nullable|in:Small,Medium,Large',
            //'ph_code'             => 'nullable|exists:countries,ph_code',
            'phone'               => ['required','digits:10',$validate_phone],
            //'whatsapp_code'       => 'nullable|exists:countries,ph_code',
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
            //'contact_person_ph_code.*'    => 'nullable|string|exists:countries,ph_code',
            'contact_person_phone'        => 'required|array|min:1',
            'contact_person_phone.*'      => ['required','digits:10',$validate_cp_phone],
            'contact_person_whatsapp'     => 'nullable|array|min:1',
            'contact_person_whatsapp.*'   => ['nullable','digits:10',$validate_whatsapp],
            'contact_person_email'        => 'nullable|array|min:1',
            'contact_person_email.*'      => 'nullable|email|unique:relcontacts,email',
            'contact_person_comment'      => 'nullable|array|min:1',
            'contact_person_comment.*'    => 'nullable|string|min:1',

            // 'coattachtypes'               => 'nullable|array|min:1',
            // 'coattachtypes.*'             => 'required|exists:coattachtypes,id',
            // 'coattachments'               => 'required|array|min:1',
            // 'coattachments.*'             => 'required|array|min:1',
            // 'coattachments.*.*'           => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
            
        ], [
                'required'             => 'This field is required.',
                'gstin.required_if'    => 'This field is required.',
                'contact_email.unique' => 'This email has already been taken.',
                'max'                  => 'Maximum 100 characters allowed.',
                'contact_comment.max'  => 'Maximum 255 characters allowed.',
                'exists'               => "This field's value is invalid.",
                'distinct'             => 'Duplicate value.',
                'email'                => 'This email is invalid.',
                
                'halting_charges_per_day.required_if' => 'Please enter halting charges per day when halting charge is checked.',
            
                'phone.digits' => 'This field must contain 10 digits.',
                'whatsapp.digits' => 'This field must contain 10 digits.',
                'contact_person_phone.*.digits' => 'This field must contain 10 digits.',
                'contact_person_whatsapp.*.digits' => 'This field must contain 10 digits.',
            
                'contact_name.required' => 'This field is required.',
                'contact_name.max'      => 'This cannot exceed 100 characters.',
            ]
        );
        
        
        
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
            } else {
                $seenPhones[] = $phone;
            }
        }

        foreach ($cpNames as $key => $name) {
            if (!$name) continue;
        
            if (in_array($name, $seenNames)) {
                $errors["contact_person_name.$key"][] = 'Duplicate name.';
                $errorcount++;
            } else {
                $seenNames[] = $name;
            }
        }

        foreach ($cpWhats as $key => $wa) {
            if (!$wa) continue;
        
            if (in_array($wa, $seenWhats)) {
                $errors["contact_person_whatsapp.$key"][] = 'Duplicate WhatsApp number.';
                $errorcount++;
            } else {
                $seenWhats[] = $wa;
            }
        }
        
        
        
        
        
        // For ADD NEW → no previous attachments
        $attachtype_ids = [];
        
        $attachtypes = $request->attachtypes ?? [];
        $filesInput  = $request->file('files') ?? [];
        
        $max = max(count($attachtypes), count($filesInput));
        
        for ($key = 0; $key < $max; $key++) {
        
            $attachtype = $attachtypes[$key] ?? null;
            $files      = $filesInput[$key] ?? null;
        
            // BOTH EMPTY → OK
            if (empty($attachtype) && empty($files)) {
                continue;
            }
        
            // FILE GIVEN BUT TYPE MISSING
            if (!empty($files) && empty($attachtype)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['Document type is required.'];
                continue;
            }
        
            // TYPE GIVEN BUT FILE MISSING
            if (!empty($attachtype) && empty($files)) {
                $errorcount++;
                $errors['coattachments_'.$key] = ['Please upload file.'];
                continue;
            }
        
            // DUPLICATE TYPE IN SAME REQUEST
            if (in_array($attachtype, $attachtype_ids)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['You’ve already added this attachment type.'];
                continue;
            }
        
            // Store type so next rows can't repeat
            $attachtype_ids[] = $attachtype;
        
            // FILE VALIDATION
            if (!empty($files)) {
        
                if (count($files) > 2) {
                    $errorcount++;
                    $errors['coattachments_'.$key] = ['You cannot upload more than 2 files.'];
                }
        
                foreach ($files as $file) {
        
                    $extension = strtolower($file->getClientOriginalExtension());
                    $size      = $file->getSize();
        
                    if (!in_array($extension, ['jpg','jpeg','png','pdf'])) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File type must be jpg, jpeg, png or pdf.'];
                    }
        
                    if ($size > 2097152) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File size must not exceed 2MB.'];
                    }
                }
            }
        }
        

        //$errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        $errormessages = $validator->errors()->toArray();

        foreach ($errors as $key => $value) {
            if (isset($errormessages[$key])) {
                $errormessages[$key] = array_merge($errormessages[$key], $value);
            } else {
                $errormessages[$key] = $value;
            }
        }
        
        if ($validator->fails() || $errorcount > 0) {
            \Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                'custom_errors' => $errors,
                //'input' => request()->all(), // optional: log the input data for context
            ]);
            
            return response()->json([
                'success' => false,
                'data' => $errormessages,
                'message' => 'Please check validation error.'
            ], 422);
        }
        
 
        
        try {
            $contact = [];
            
            DB::transaction(function () use ($request, &$contact) {
                
                $lastcontact = Contact::withTrashed()->orderBy('id', 'DESC')->first();
                if($lastcontact){
                    $lastcontactno = (int) $lastcontact->contactno;
                    $incr_lastcontact = $lastcontactno+1;
                    if(strlen($incr_lastcontact)<5){
                        $contactno = '0';
                        for($i = 0; $i<(5-strlen($incr_lastcontact)); $i++){
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
            
                //\Log::info('Current locale:', ['p' => $phoneCode]);
            
                $contact  = new Contact;
                $contact->contactno       = $contactno;
                $contact->cotype_id       = self::CONTACT_TYPE_CUSTOMER;
                $contact->organisation_id = optional(Auth::user()?->organisation)->id;
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
                
                $contact->created_by         = Auth::user()->id;
                
                $contact->save();
                
                
                
                // Contact Persons + Users
                $names = $request->get('contact_person_name', []);
                for ($i = 0; $i < count($names); $i++) {
                    $name  = $names[$i] ?? null;
                    $designation = $request->contact_person_designation[$i] ?? null;
                    $ph_code = $request->contact_person_ph_code[$i] ?? $phoneCode;
                    $phone = $request->get('contact_person_phone')[$i] ?? null;
                    
                    $whatsapp_code = $request->contact_person_whatsapp_code[$i] ?? $phoneCode;
                    $whatsapp = $request->get('contact_person_whatsapp')[$i] ?? null;
                    
                    $email = $request->get('contact_person_email')[$i] ?? null;
                    $comment = $request->get('contact_person_comment')[$i] ?? null;
                
                    // Skip if name, email, and phone all are empty
                    if (empty($name) && empty($email) && empty($phone)) {
                        continue;
                    }
                
                    // Create user only if email exists (to avoid duplicate blank users)
                    // if (!empty($email)) {
                    //     $user = new User;
                    //     $user->name       = $name;
                    //     $user->email      = $email;
                    //     $user->password   = Hash::make(Str::random(8));
                    //     $user->contact_id = $contact->id;
                    //     $user->save();
                    // }
                
                    // Always create related contact if name or phone/email present
                    $relatedContact = new Relcontact;
                    $relatedContact->contact_id = $contact->id;
                    $relatedContact->name       = $name;
                    $relatedContact->position   = $designation;
                    $relatedContact->ph_prefix  = $ph_code ?? $phoneCode;
                    $relatedContact->phone      = $phone;
                    $relatedContact->whatsapp_prefix  = $whatsapp_code ?? $phoneCode;
                    $relatedContact->whatsapp      = $whatsapp;
                    $relatedContact->email      = $email;
                    $relatedContact->comment    = $comment;
                    $relatedContact->created_by = Auth::user()->id;
                    $relatedContact->save();
                }


            
                // Create Billing Address (only if any billing field is filled)
                if (
                    !empty($request->get('billing_state_id')) ||
                    !empty($request->get('billing_city_id')) ||
                    !empty($request->get('billing_postalcode')) ||
                    !empty($request->get('billing_address')) ||
                    !empty($request->get('billing_additionalinfo'))
                ) {
                    $billing_address = new Cobilling;
                    $billing_address->country_id   = $request->get('billing_country');
                    $billing_address->state_id     = $request->get('billing_state_id');
                    $billing_address->city_id      = $request->get('billing_city_id');
                    $billing_address->address1     = $request->get('billing_address');
                    $billing_address->zipcode      = $request->get('billing_postalcode');
                    $billing_address->add_info     = $request->get('billing_additionalinfo');
                    $billing_address->contact_id   = $contact->id;
                    $billing_address->created_by   = Auth::user()->id;
                    $billing_address->save();
                }
                
                
                
                
                $attachtypes = $request->attachtypes;
                if(!empty($attachtypes)){
                    foreach($attachtypes as $key => $attachtype){
                        if(isset($request->file('files')[$key])){
                            $files = $request->file('files')[$key];
                            
                            foreach($files as $file){
                                $fileoriginalname = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();
                                $filesize = $file->getSize();

                                // Keep original extension
                                $filename = 'contact-attachment-'.Str::random(4).'_'.time().'.'.$extension;

                                $file->move(
                                    public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR),
                                    $filename
                                );
                                
                                
                                $contact_attachment = new Coattachment;
                                $contact_attachment->name              = $filename;
                                $contact_attachment->original_name     = $fileoriginalname;
                                $contact_attachment->file_size         = ($filesize/(1024 *1024));
                                $contact_attachment->coattachtype_id   = $attachtype;
                                $contact_attachment->created_by        = Auth::id();
                                $contact_attachment->contact_id        = $contact->id;
                                $contact_attachment->save();
                            }
                        }
                    } 
                }
                
                
                // Log activity
                $description = 'Added new customer contact with ID ' . $contact->id;
                $this->storeUseractivity(1, 3, Auth::user()->id, $contact->id, $description);

            });
        
        
            return response()->json([
                'success' => true,
                'data'    => $contact,
                'message' => 'Customer saved successfully.'
            ]);
            
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage()
            ]);
        }
    }
    
    
    public function editCustomer(Request $request, $id) 
    {
         $organisationId = organisation_id();
         
         $contact = Contact::with([
             'country.states',
             'state.cities',
             'relcontacts' => function ($q) {
                    $q->orderBy('id', 'asc');
             },
             'cobilling',
             'cobilling.state.cities',
             'cobilling.country.states',
             'coattachments.coattachtype',
             'vehicleAllocations.vehicle', 
             'vehicleAllocations.createdby',
             'activities',
             'activities.createdBy',
         ])
         ->where('cotype_id',self::CONTACT_TYPE_CUSTOMER)
         ->where('id',$id)
         ->first();
         
        //dd($contact);
        //dd($contact->customercontracts);
        //dd($contact->relcontacts);
        
         $countries = Country::all();
         $states    = State::all();
         $cotypes   = Cotype::all();
         $coattachtypes = Coattachtype::all();
         $customerabouttype = Customerabouttype::orderBy('name')->get();
        
         $gsttreats = Gsttreat::all();
         $cotype = $cotypes->firstWhere('id', self::CONTACT_TYPE_CUSTOMER);
         
         $contract = $contact->customercontracts->first();
         
         $hasContract = $contact && $contact->customercontracts->isNotEmpty();
         //dd($hasContract);
         
         $allRoutes = $contact->customercontracts
                                ->flatMap(fn($contract) => $contract->routes)
                                ->unique('id')
                                ->values()
                                ->map(function ($route) {
                                    return $route->load(['sourceState', 'sourceCity', 'destinationState', 'destinationCity', 'tollstations','rtos','midpoints']);
                                });
                                

        // Unique source states
        $routeSourceStates = $allRoutes->pluck('sourceState')->filter()->unique('id')->values();

        // Unique source cities
        $routeSourceCities = $allRoutes->pluck('sourceCity')->filter()->unique('id')->values();

        // Unique destination states
        $routeDestStates = $allRoutes->pluck('destinationState')->filter()->unique('id')->values();

        // Unique destination cities
        $routeDestCities = $allRoutes->pluck('destinationCity')->filter()->unique('id')->values();


        // Unique midpoints
        $routeMidpoints = $allRoutes->flatMap(fn($route) => $route->midpoints)->unique('id')->values();     
        $routeMidpointStates = $routeMidpoints->pluck('state')->filter()->unique('id')->values();
        $routeMidpointCities = $routeMidpoints->pluck('city')->filter()->unique('id')->values();
        
        
        $routes = Route::with(['tollstations.tollstation','rtos.rto',
                            'sourceState',
                            'sourceCity',
                            'destinationState',
                            'destinationCity',
                            'midpoints',
                            'midpoints.state',
                            'midpoints.city',
                            'currency',
                        ])->get();
                        
                        
        $today = Carbon::today();
        // $activeContracts = Customercontract::where('contact_id', $id) // if customer specific
        //                                         ->where(function ($query) use ($today) {
                                            
        //                                             $query->where('contract_type_id', 6) // Life Time
                                            
        //                                                   ->orWhere(function ($q) use ($today) {
        //                                                       $q->whereNotNull('start_date')
        //                                                         ->whereNotNull('end_date')
        //                                                         ->where('start_date', '<=', $today)
        //                                                         ->where('end_date', '>=', $today);
        //                                                   });
                                            
        //                                         })
        //                                         ->orderByDesc('created_at')
        //                                         ->get();
        
        
        
        $activeContracts = Customercontract::where('contact_id', $id)->orderByDesc('created_at')->get();
                                                
                                                
        $vehicletypes = Vehicletype::where('status', 'Active')->orderBy('name')->get();
        
        
        
        $sourceLoadingPoints = Customerlocation::where('contact_id', $id)->where('route_type', 'source')->whereIn('location_type', ['Loading', 'Both'])->get();
        $destinationUnloadingPoints = Customerlocation::where('contact_id', $id)->where('route_type', 'destination')->whereIn('location_type', ['Unloading', 'Both'])->get();
        $midPoints = Customerlocation::where('contact_id', $id)->where('route_type', 'midpoint')->get();
        
        
        

        $contractPricings = Contractpricing::with([
                                                'customerContract',
                                                'contractroute.route',
                                                'locationPoints.location',
                                                'vehicles.vehicleType',
                                                'vehicles.vehicleTypeSize'
                                            ])->where('contact_id', $contact->id)
                                              ->latest()
                                              ->get()
                                              ->groupBy('customercontract_id');
  
        //dd($contractPricings);
        
        
        $vehicles = Vehicle::where('status', 'Active')->orderBy('vehicle_no')->get();
        $vehicleAllocations = $contact->vehicleAllocations()
                                           ->with(['vehicle', 'createdby'])
                                           ->orderByDesc('created_at')
                                           ->get();
        
         
        // Log activity
        $description = 'Retrieve a customer named '.$contact->contact_name.' to edit.';
        $useractivity = $this->storeUseractivity(1, 5, Auth::user()->id, $contact->id, $description);
        
         
        return view('contacts.customer.edit', compact('customerabouttype',
                                                     'cotype',
                                                     'contact',
                                                     'contract',
                                                     'hasContract',
                                                     'routes',
                                                     'countries',
                                                     'states',
                                                     'cotypes',
                                                     'coattachtypes',
                                                     'gsttreats',
                                                     'allRoutes',
                                                     'routeSourceStates',
                                                     'routeSourceCities',
                                                     'routeDestStates',
                                                     'routeDestCities',
                                                     'routeMidpoints',
                                                     'routeMidpointStates',
                                                     'routeMidpointCities',
                                                     'activeContracts',
                                                     'vehicletypes',
                                                     'sourceLoadingPoints',
                                                     'destinationUnloadingPoints',
                                                     'midPoints',
                                                     'contractPricings',
                                                     'vehicles',
                                                     'vehicleAllocations'
                                                    ));
                                                    
    }
    
    
    
    public function updateCustomer(Request $request, $id)
    {
        // === Clean phone numbers (intl-tel-input adds spaces) ===
        $request->merge([
            'phone'    => preg_replace('/\s+/', '', $request->phone),
            'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp),
        ]);
        
        // Clean contact person phones
        if ($request->has('contact_person_phone')) {
            $phones = $request->contact_person_phone;
        
            foreach ($phones as $k => $p) {
                $phones[$k] = preg_replace('/\s+/', '', $p);
            }
        
            $request->merge(['contact_person_phone' => $phones]);
        }
        
        // Clean contact person whatsapp
        if ($request->has('contact_person_whatsapp')) {
            $whatsapps = $request->contact_person_whatsapp;
        
            foreach ($whatsapps as $k => $w) {
                $whatsapps[$k] = preg_replace('/\s+/', '', $w);
            }
        
            $request->merge(['contact_person_whatsapp' => $whatsapps]);
        }
        
        
        $validate_phone = function (string $attribute, mixed $value, Closure $fail) use ($id) {

            // Always take phone code from helper (not from request)
            $code = getPhoneCode();
        
            if (!$code) {
                //$fail('Phone number requires a country code.');
            }
        
            if (
                Contact::where('phone', $value)
                    ->where('ph_prefix', $code)
                    ->where('id', '!=', $id)
                    ->exists()
            ) {
                $fail('This phone number already exists.');
            }
        };


    
        $validate_cp_email = function (string $attribute, mixed $value, Closure $fail) use ($request) {
            $index = explode('.', $attribute)[1] ?? null;
            $email = $value;
            $person_id = $request->input("contact_person_id.$index");
    
            if ($email && $email !== null) {
                $query = Contact::where('email', $email);
                if ($person_id) {
                    $query->where('id', '!=', $person_id);
                }
    
                if ($query->exists()) {
                    $fail("The email $email is already taken.");
                }
            }
        };
    
        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) {

            $code = getPhoneCode();
        
            if (!$code) {
                //$fail('Contact person phone number requires a country code.');
            }
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
            'gst_number'          => 'required|max:100',
            'contact_name'        => 'required|max:100',
            'about_type_id'       => 'required|exists:customerabouttypes,id',
            'size'                => 'nullable|in:Small,Medium,Large',
            'email'               => [
                                    'nullable',
                                    'email',
                                    Rule::unique('contacts', 'email')->ignore($id),
                                  ],
            //'ph_code'             => 'nullable|exists:countries,ph_code',
            'phone'                 => ['required','digits:10',$validate_phone],
            //'whatsapp_code'       => 'nullable|exists:countries,ph_code',
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
            //'contact_person_ph_code.*'    => 'nullable|string|exists:countries,ph_code',
            
            'contact_person_phone'        => 'required|array|min:1',
            'contact_person_phone.*'      => ['required','digits:10','distinct',$validate_cp_phone],
            'contact_person_whatsapp'     => 'nullable|array|min:1',
            'contact_person_whatsapp.*'   => ['nullable','digits:10','distinct',$validate_cp_phone],
            
            'contact_person_email'        => 'nullable|array|min:1',
            'contact_person_email.*'      => [
                                                'nullable',
                                                'email',
                                                'distinct',
                                                $validate_cp_email
                                            ],
            'contact_person_comment'      => 'nullable|array|min:1',
            'contact_person_comment.*'    => 'nullable|string|distinct|min:1',
            

            // 'coattachtypes'               => 'nullable|array|min:1',
            // 'coattachtypes.*'             => 'nullable|exists:coattachtypes,id',
            // 'coattachments'               => 'nullable|array|min:1',
            // 'coattachments.*'             => 'nullable|array|min:1',
            // 'coattachments.*.*'           => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
            // 'delete_coattachment_ids'     => 'sometimes|array|min:1',
            // 'delete_coattachment_ids.*'   => [
            //         'required',
            //          Rule::exists('coattachments','id')
            //          ->whereNull('deleted_at')
            //          ->where('contact_id',$contact->id)
            //  ]
        ], [
                'required'             => 'This field is required.',
                'gstin.required_if'    => 'This field is required.',
                'contact_email.unique' => 'This email has already been taken.',
                'max'                  => 'Maximum 100 characters allowed.',
                'contact_comment.max'  => 'Maximum 255 characters allowed.',
                'exists'               => "This field's value is invalid.",
                'distinct'             => 'Duplicate value.',
                'email'                => 'This email is invalid.',
                
                'halting_charges_per_day.required_if' => 'Please enter halting charges per day when halting charge is checked.',
                
                // Custom field-specific messages:
                'phone.digits' => 'This field must contain 10 digits.',
                'whatsapp.digits' => 'This field must contain 10 digits.',
                'contact_person_phone.*.digits' => 'This field must contain 10 digits.',
                'contact_person_whatsapp.*.digits' => 'This field must contain 10 digits.',
            
                'contact_name.required' => 'This field is required.',
                'contact_name.max'      => 'This cannot exceed 100 characters.',
            ]
        );
    
        

        $errorcount = 0;
        $errors = [];
        
        
        $attachtype_ids = [];
        if(isset($contact)){
            $attachtype_ids = $contact->coattachments->pluck('coattachtype_id')->toArray();
        }
        
        $attachtypes = $request->attachtypes ?? [];
        $filesInput  = $request->file('files') ?? [];
        
        $max = max(count($attachtypes), count($filesInput));
        
        $allKeys = array_unique(array_merge(
                    array_keys($attachtypes),
                    array_keys($filesInput)
                ));

        foreach ($allKeys as $key) {
        
            $attachtype = $attachtypes[$key] ?? null;
            $files      = $filesInput[$key] ?? null;
        
            // BOTH EMPTY → OK
            if (empty($attachtype) && empty($files)) {
                continue;
            }
        
            // FILE GIVEN BUT TYPE MISSING
            if (!empty($files) && empty($attachtype)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['Document type is required.'];
                continue;
            }
        
            // TYPE GIVEN BUT FILE MISSING
            if (!empty($attachtype) && empty($files)) {
                $errorcount++;
                $errors['coattachments_'.$key] = ['Please upload file.'];
                continue;
            }
        
            // DUPLICATE TYPE CHECK
            if (!empty($attachtype_ids) && in_array($attachtype, $attachtype_ids, true)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['You’ve already added this attachment type.'];
                continue;
            }
        
            $attachtype_ids[] = $attachtype;
        
            // FILE VALIDATION
            if (!empty($files)) {
        
                if (count($files) > 2) {
                    $errorcount++;
                    $errors['coattachments_'.$key] = ['You cannot upload more than 2 files.'];
                }
        
                foreach ($files as $file) {
        
                    $extension = strtolower($file->getClientOriginalExtension());
                    $size      = $file->getSize();
        
                    if (!in_array($extension, ['jpg','jpeg','png','pdf'])) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File type must be jpg, jpeg, png or pdf.'];
                    }
        
                    if ($size > 2097152) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File size must not exceed 2MB.'];
                    }
                }
            }
        }
        
        
        
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            \Log::error('Validation failed', [
                'validator_errors' => $validator->errors()->toArray(),
                'custom_errors'    => $errors,
                'final_errors'     => $errormessages,
            ]);
            
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
    
        try {
            
            
            DB::transaction(function () use ($request, $contact) {
                
                $phoneCode = getPhoneCode();
            
                //\Log::info('Current locale:', ['p' => $phoneCode]);
                
                
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
                $contact->halting_charges_per_day = $contact->is_deduction_chargeable ? ($request->get('halting_charges_per_day') ?? 0) : 0;
                $contact->comment  = $request->contact_comment;
                $contact->gstin  = $request->gst_number;
                $contact->status          = $request->get('status') ?? 'Active';
                $contact->blacklist_reason = $request->get('blacklist_reason') ?? null;
                if ($request->get('status') === 'Blacklisted') {
                    $contact->blacklisted_at = now();
                }else {
                    $contact->blacklisted_at = null;
                }
                $contact->updated_by      = Auth::user()->id;
                $contact->save();
                
                
                if ($request->filled('blacklist_reason')) {
                    $activity = new Contactactivity();
                    $activity->contact_id = $contact->id;
                    $activity->notes = $request->blacklist_reason; 
                    $activity->is_blacklisted = 'Yes';
                    $activity->created_by = Auth::user()->id;
                    $activity->save();
                }
                
    
                // === Update Relcontacts ===
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
                    $rel->whatsapp      = $request->contact_person_whatsapp[$i] ?? null;
                    $rel->email     = $request->contact_person_email[$i] ?? null;
                    $rel->comment   = $request->contact_person_comment[$i] ?? null;
                    $rel->save();
    
                    $relcontact_ids[] = $rel->id;
                }
    
                Relcontact::where('contact_id', $contact->id)
                          ->whereNotIn('id', $relcontact_ids)
                          ->delete();
    
                // === Update Billing Addresses ===
                Cobilling::where('contact_id', $contact->id)->delete();
                if (
                    !empty($request->get('billing_state_id')) ||
                    !empty($request->get('billing_city_id')) ||
                    !empty($request->get('billing_postalcode')) ||
                    !empty($request->get('billing_address')) ||
                    !empty($request->get('billing_additionalinfo'))
                ) {
                    $billing_address = new Cobilling;
                    $billing_address->country_id   = $request->billing_country;
                    $billing_address->state_id     = $request->billing_state_id;
                    $billing_address->city_id      = $request->billing_city_id;
                    $billing_address->address1     = $request->billing_address;
                    $billing_address->zipcode      = $request->billing_postalcode;
                    $billing_address->add_info     = $request->billing_additionalinfo;
                    $billing_address->contact_id   = $contact->id;
                    $billing_address->created_by   = Auth::user()->id;
                    $billing_address->save();
                }
    
                
                // === TODO: Handle Attachments (if needed) ===
                $attachtypes = $request->attachtypes;
                if(!empty($attachtypes)){
            
                    foreach($attachtypes as $key => $attachtype){
                        
                        if(isset($request->file('files')[$key])){
                            $files = $request->file('files')[$key];
                            
                            foreach($files as $file){
                                $fileoriginalname = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();
                                $filesize = $file->getSize();

                                // Keep original extension
                                $filename = 'contact-attachment-'.Str::random(4).'_'.time().'.'.$extension;

                                $file->move(
                                    public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR),
                                    $filename
                                );
                                
                                
                                $contact_attachment = new Coattachment;
                                $contact_attachment->name              = $filename;
                                $contact_attachment->original_name     = $fileoriginalname;
                                $contact_attachment->file_size         = ($filesize/(1024 *1024));
                                $contact_attachment->coattachtype_id   = $attachtype;
                                $contact_attachment->created_by        = Auth::id();
                                $contact_attachment->contact_id        = $contact->id;
                                $contact_attachment->save();
                            }
                            
                        }
                    } 
                }
                
                
                // Log activity
                $this->storeUseractivity(1, 4, Auth::user()->id, $contact->id, 'Customer Updated [ID: ' . $contact->id . '].');
                
            });
    
            return response()->json([
                'success' => true,
                'data'    => $contact,
                'message' => 'Customer updated successfully.'
            ]);
        } catch (\Exception $exp) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage()
            ]);
        }
    }
    
    
    
    
    
    // Customer Contract Section ---------------------------------------------------------------------------------------------
 
    public function showCustomerContractForm($customerid, $contractid = null)
    {
        // Fetch the customer
        $contact = Contact::with([
                    'customercontracts',
                    'cotype'
                ])
                ->where('cotype_id', self::CONTACT_TYPE_CUSTOMER)
                ->findOrFail($customerid);
    
        // Fetch the contract if contractid is provided
        $contract = null;
        if ($contractid) {
            $contract = Customercontract::where('contact_id', $contact->id)
                                        ->where('id', $contractid)
                                        ->first();
                                        
            
        }
    
        // Fetch any data needed for the form
        $contractTypes = Contracttype::all(); // example, adjust as needed
    
        // Optional: pass existing contract file path if editing
        $contractFile = $contract?->contract_file;
        
        $cotype = $contact->cotype;
        $customers = Contact::where('cotype_id', self::CONTACT_TYPE_CUSTOMER)->get();
        
        $routes = Route::where('status', 'Active')->get();
    
        // Log activity
        $description = $contract 
                        ? "Editing contract [ID: {$contract->id}] for customer {$contact->contact_name}"
                        : "Creating new contract for customer {$contact->contact_name}";
        $this->storeUseractivity(46, 5, Auth::id(), $contact->id, $description);
    
        // Return view
        return view('contacts.customer.contract-form', compact(
            'contact',
            'contract',
            'contractTypes',
            'contractFile',
            'cotype',
            'customerid',
            'contractid',
            'customers',
            'routes',
        ));
    }

    public function storeCustomerContract(Request $request)
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
            
            // default rules (will be overridden conditionally)
            'start_date'        => 'nullable|date|after_or_equal:today',
            'end_date'          => 'nullable|date|after_or_equal:start_date',
            
            // conditional fields
            'total_allowed_kilometer' => 'required_if:contract_type_id,1|numeric|min:0',
            'monthly_total_price'     => 'required_if:contract_type_id,1|decimal:0,2|min:0',
            
            // reminder
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
        
        /**
         * If contract_type_id is NOT 6 → dates are required
         */
        $validator->sometimes(
            ['start_date', 'end_date'],
            'required|date',
            function ($input) {
                return (int) $input->contract_type_id !== 6;
            }
        );
        
        /**
         * Extra rule only when required
         */
        $validator->sometimes(
            'end_date',
            'after_or_equal:start_date',
            function ($input) {
                return (int) $input->contract_type_id !== 6;
            }
        );
        
        /**
         * If set_reminder is Yes → reminder_days_before_expiry is required
         */
        $validator->sometimes(
            'reminder_days_before_expiry',
            'required|integer|min:1',
            function ($input) {
                return isset($input->set_reminder) && $input->set_reminder === 'Yes';
            }
        );
    
        if ($validator->fails()) {
            \Log::warning('Contract validation failed', [
                'errors' => $validator->errors()->toArray(),
            ]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.'
            ], 422);
        }
        
        // Check for overlapping contract details
        $start = $request->start_date;
        $end   = $request->end_date;
        $contactId = $request->contact_id;
        
        $contactId = $request->contact_id;

        if ((int) $request->contract_type_id !== 6) {
        
            $start = $request->start_date;
            $end   = $request->end_date;
        
            $overlap = Customercontract::where('contact_id', $contactId)
                ->where('contract_type_id', '!=', 6) // ignore lifetime contracts
                ->where(function ($query) use ($start, $end) {
                    $query->whereBetween('start_date', [$start, $end])
                          ->orWhereBetween('end_date', [$start, $end])
                          ->orWhere(function ($q) use ($start, $end) {
                              $q->where('start_date', '<=', $start)
                                ->where('end_date', '>=', $end);
                          });
                })
                ->exists();
        
            if ($overlap) {
                return response()->json([
                    'success' => false,
                    'data' => [],
                    'message' => 'There is already a contract that overlaps with the selected date range.'
                ], 422);
            }
        }

    
        if ((int) $request->contract_type_id === 6) {

            $lifetimeExists = Customercontract::where('contact_id', $contactId)->where('contract_type_id', 6)->exists();
        
            if ($lifetimeExists) {
                return response()->json([
                    'success' => false,
                    'data' => [],
                    'message' => 'A Lifetime contract already exists for this customer.'
                ], 422);
            }
        }
        

    
        try {
            
            $contractdata = DB::transaction(function () use ($request) {
                    
                    // Handle file upload
                    $filename = null;
                    if ($request->hasFile('upload_file') && $request->file('upload_file')->isValid()) {
                    
                        $file = $request->file('upload_file');
                    
                        // original extension
                        $extension = $file->getClientOriginalExtension();
                    
                        // safe unique filename
                        $filename = 'contract_' . time() . '_' . uniqid() . '.' . $extension;
                    
                        $uploadPath = public_path('media/customer-contract');
                    
                        // Ensure directory exists
                        if (!File::exists($uploadPath)) {
                            File::makeDirectory($uploadPath, 0755, true);
                        }
                    
                        // Move file
                        $file->move($uploadPath, $filename);
                    
                        // Save this in DB
                        $filePath = 'media/customer-contract/' . $filename;
                    }
                    
                    
                    // Clean numeric fields (avoid '' decimal error)
                    $monthlyKm = $request->filled('total_allowed_kilometer') ? str_replace(',', '', $request->total_allowed_kilometer) : 0;
                    $monthlyPrice = $request->filled('monthly_total_price') ? str_replace(',', '', $request->monthly_total_price) : 0;
            
                    
                    // Save Contract
                    $contract = new Customercontract();
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
                        
                    // Save Contract Detail
                    $detail  = new Customercontractdetail;
                    $detail->customercontract_id  = $contract->id;
                    $detail->contract_file        = $filename;
                    $detail->contract_expiry_date = $request->end_date ?? null;
                    $detail->set_reminder         = $request->set_reminder ?? 'No';
                    $detail->reminder_days_before_expiry = $request->reminder_days_before_expiry ?? null;
                    $detail->created_by = Auth::user()->id;
                    $detail->save();
                    
                    // Save Routes (skip empty values)
                    if ($request->has('route_id')) {
                        foreach ($request->route_id as $routeId) {
                            $route  = new Contractroute;
                            $route->customercontract_id  = $contract->id;
                            $route->route_id  = $routeId;
                            $route->save();
                        }
                    }
                    
        
                    return $contract;
            });
    
            return response()->json([
                'success' => true,
                'data'    => $contractdata,
                'message' => 'Customer contract data saved successfully.'
            ]);
    
        } catch (\Throwable $e) {
            \Log::error('CustomerContractDetail save failed', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
    
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function customerContractList(Request $request): View
    {
        $search_customer_id = $request->get('customer');
        $search_contractno = $request->get('contractno');
        
        $contracts = Customercontract::with(['contact', 'contracttype', 'detail'])
        
                                // Search by contract no
                                ->when($search_contractno, function ($q) use ($search_contractno) {
                                    $q->where('contract_no', $search_contractno);
                                })
                            
                                // Search by customer id
                                ->when($search_customer_id, function ($q) use ($search_customer_id) {
                                    $q->where('contact_id', $search_customer_id);
                                })
                                
                                // Start Date
                                ->when($request->start_daterange, function ($query) use ($request) {
                                    $dates = explode(' to ', $request->start_daterange);
                                
                                    if (count($dates) === 2) {
                                        $from = Carbon::createFromFormat('d-m-Y', $dates[0])->format('Y-m-d');
                                        $to   = Carbon::createFromFormat('d-m-Y', $dates[1])->format('Y-m-d');
                                
                                        $query->whereBetween('start_date', [$from, $to]);
                                    }
                                })
                                
                                // End Date
                                ->when($request->end_daterange, function ($query) use ($request) {
                                    $dates = explode(' to ', $request->end_daterange);
                                
                                    if (count($dates) === 2) {
                                        $from = Carbon::createFromFormat('d-m-Y', $dates[0])->format('Y-m-d');
                                        $to   = Carbon::createFromFormat('d-m-Y', $dates[1])->format('Y-m-d');
                                
                                        $query->whereBetween('end_date', [$from, $to]);
                                    }
                                })
                            
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);

        //dd($contracts);
        
        $customers = Contact::where('cotype_id', self::CONTACT_TYPE_CUSTOMER)->get(); 
        
        $contractNumbers = Customercontract::select('contract_no')
                                            ->whereNotNull('contract_no')
                                            ->distinct()
                                            ->orderBy('contract_no', 'ASC')
                                            ->pluck('contract_no');
        
        return view('contacts.customer.contract-master', compact('contracts','search_customer_id','search_contractno','customers','contractNumbers'));
    }
    
    
    public function deleteCustomerContract(Request $request)
    {
        try {
            
            $id = $request->input('id');        
            $actmodelid = $request->input('actmodelid');

            $deletedContract = DB::transaction(function () use ($request) {
                $contract = Customercontract::with('detail')->find($request->id);
    
                if (!$contract) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Contract not found.'
                    ], 404);
                }
    
                if ($contract->delete()) {
                    return $contract; 
                }
                
                throw new \Exception('Delete failed');
            });
            
            // Only here, after delete succeeded, log activity
            $description = 'Deleted a contact.';
            $this->storeUseractivity($actmodelid, 6, Auth::user()->id, $deletedContract->id, $description);
    
            return response()->json([
                'success' => true,
                'data'    => $deletedContract,
                'message' => 'Customer contract deleted successfully.'
            ]);
    
        } catch (\Throwable $e) {
    
            \Log::error('Contract delete failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
    
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }
    
    
    public function editCustomerContract($id)
    {
        // Fetch contract with all required relations
        $contract = Customercontract::with([
                        'contact',
                        'contracttype',
                        'detail',
                        'routes'
                    ])->findOrFail($id);
                    
        //dd($contract->routes);
    
        // Dropdown / master data
        $contractTypes = Contracttype::orderBy('id')->get();
        $customers = Contact::where('cotype_id', self::CONTACT_TYPE_CUSTOMER)->get();
        $cotype = Cotype::where('slug', 'customer')->first();
        $routes = Route::where('status', 'Active')->get();
    
        // Log activity (optional)
        $description = 'Edit contract '.$contract->contract_no;
        $this->storeUseractivity(46, 5, auth()->id(), $contract->id, $description);
    
        return view('contacts.customer.contract-edit-form', compact('contract','contractTypes','customers','cotype','routes'));
        
    }
    
    public function updateCustomerContract(Request $request)
    {
        $request->merge([
            'total_allowed_kilometer' => $request->filled('total_allowed_kilometer')
                ? str_replace(',', '', $request->total_allowed_kilometer)
                : null,
    
            'monthly_total_price' => $request->filled('monthly_total_price')
                ? str_replace(',', '', $request->monthly_total_price)
                : null,
        ]);
        
        $validator = Validator::make($request->all(), [
            'contract_id'       => 'required|exists:customercontracts,id',
            //'contact_id'        => 'required|exists:contacts,id',
            //'contract_no'       => 'required|string|max:100',
            //'contract_type_id'  => 'required|exists:contracttypes,id',
            'advance_payment'   => 'required|numeric|min:0',
            'payment_within_day'=> 'required|integer|min:0',
            'remarks'           => 'nullable|string|max:255',
            
            'route_id'          => 'required|array|min:1',
            'route_id.*'        => 'required|exists:routes,id',
    
            //'start_date'        => 'nullable|date',
            //'end_date'          => 'nullable|date|after_or_equal:start_date',
    
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
    
        // dates required except type 6
        // $validator->sometimes(
        //     ['start_date', 'end_date'],
        //     'required|date',
        //     fn ($i) => (int)$i->contract_type_id !== 6
        // );
    
        // reminder rule
        $validator->sometimes(
            'reminder_days_before_expiry',
            'required|integer|min:1',
            fn ($i) => $i->set_reminder === 'Yes'
        );
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Validation failed'
            ], 422);
        }

        /* ================= Overlap check (IGNORE SELF) ================= */
        $overlap = false;
        if ($request->start_date && $request->end_date) {
        
            $overlap = Customercontract::where('contact_id', $request->contact_id)
                ->where('id', '!=', $request->contract_id)
                ->where(function ($q) use ($request) {
                    $q->whereBetween('start_date', [$request->start_date, $request->end_date])
                      ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                      ->orWhere(function ($qq) use ($request) {
                          $qq->where('start_date', '<=', $request->start_date)
                             ->where('end_date', '>=', $request->end_date);
                      });
                })
                ->exists();
        }
    
        if ($overlap) {
            return response()->json([
                'success' => false,
                'message' => 'Overlapping contract exists for this customer.'
            ], 422);
        }
    
        try {

            $contract = DB::transaction(function () use ($request) {
        
                $contract = Customercontract::with('detail')
                    ->findOrFail($request->contract_id);
        
                /* ================= FILE UPLOAD ================= */
        
                $filename = optional($contract->detail)->contract_file;
        
                if ($request->hasFile('upload_file') && $request->file('upload_file')->isValid()) {
        
                    // Delete old file
                    if ($filename && File::exists(public_path('media/customer-contract/' . $filename))) {
                        File::delete(public_path('media/customer-contract/' . $filename));
                    }
        
                    $file = $request->file('upload_file');
                    $filename = 'contract_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
                    $path = public_path('media/customer-contract');
                    File::ensureDirectoryExists($path);
        
                    $file->move($path, $filename);
                }
        
                /* ================= UPDATE CONTRACT ================= */
        
                // Explicit assignments only when provided
                if ($request->has('payment_within_day')) {
                    $contract->payment_within_day = $request->payment_within_day;
                }
        
                if ($request->has('start_date')) {
                    $contract->start_date = $request->start_date;
                }
        
                if ($request->has('end_date')) {
                    $contract->end_date = $request->end_date;
                }
                
                if ($request->has('advance_payment')) {
                    $contract->advance_payment = $request->advance_payment ?? 0;
                }
        
                if ($request->has('remarks')) {
                    $contract->remarks = $request->remarks;
                }
        
                // Contract type specific logic
                if ($request->has('total_allowed_kilometer')) {
                    $contract->monthly_total_allowed_kilometer = $request->total_allowed_kilometer ?? 0;
                }
                if ($request->has('monthly_total_price')) {
                    $contract->monthly_total_price = str_replace(',', '', $request->monthly_total_price);
                }
        
                $contract->updated_by = Auth::id();
                $contract->save();
        
                /* ================= UPDATE OR CREATE DETAIL ================= */
        
                $detail = Customercontractdetail::where('customercontract_id', $contract->id)->first();

                // create new if none found
                if (!$detail) {
                    $detail = new Customercontractdetail;
                    $detail->customercontract_id = $contract->id;
                }
        
                if ($filename) {
                    $detail->contract_file = $filename;
                }
        
                if ($request->has('end_date')) {
                    $detail->contract_expiry_date = $request->end_date;
                }
        
                if ($request->has('set_reminder')) {
                    $detail->set_reminder = $request->set_reminder;
                }
        
                if ($request->set_reminder === 'Yes') {
                    if ($request->has('reminder_days_before_expiry')) {
                        $detail->reminder_days_before_expiry = $request->reminder_days_before_expiry;
                    }
                } else {
                    $detail->reminder_days_before_expiry = null;
                }
        
                $detail->updated_by = Auth::id();
                $detail->save();
        
                /* ================= SYNC ROUTES ================= */
        
                if ($request->has('route_id') && is_array($request->route_id)) {
                    $contract->routes()->sync($request->route_id);
                }
        
                return $contract->load('detail', 'routes');
            });
        
            return response()->json([
                'success' => true,
                'data' => $contract,
                'message' => 'Customer contract updated successfully.'
            ]);
        
        } catch (\Throwable $e) {
        
            \Log::error('Contract update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }

    }
    
    
    
    


    // Customer Contract Pricing Section -------------------------------------------------------------------------------------
    
    public function getContractRoutes($id)
    {
        try {
    
            $contract = Customercontract::with(['routes' => function ($query) {
                            $query->withCount('midpoints');
                        }])->find($id);
    
            if (!$contract) {
                return response()->json([
                    'success' => false,
                    'routes'  => [],
                    'message' => 'Contract not found.'
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'routes'  => $contract->routes,
                'message' => 'Routes fetched successfully.'
            ], 200);
    
        } catch (\Throwable $e) {
    
            \Log::error('Error fetching contract routes', [
                'contract_id' => $id,
                'message'     => $e->getMessage(),
                'trace'       => $e->getTraceAsString(),
            ]);
    
            return response()->json([
                'success' => false,
                'routes'  => [],
                'message' => 'Something went wrong while fetching routes.'
            ], 500);
        }
    }


    public function storeCustomerContractPricing(Request $request)
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
                        'loading_midpoint.*' => 'nullable|exists:cities,id',
                    
                        'unloading_midpoint' => 'nullable|array',
                        'unloading_midpoint.*' => 'nullable|exists:cities,id',
                
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
                            
                            // Custom after_or_equal messages
                            'applicable_end_date.after_or_equal' => 'Applicable end date must be after or equal to start date.',
                            'retrospective_end_date.after_or_equal' => 'Retrospective end date must be after or equal to start date.',
                        ]
                    );
                    
                    
                    
                    
        $validator->after(function ($validator) use ($request) {

            $vehicleTypes = $request->vehicle_type_id ?? [];
            $vehicleSizes = $request->vehicletype_size_id ?? [];
        
            // Safety check: arrays count must match
            if (count($vehicleTypes) !== count($vehicleSizes)) {
                $validator->errors()->add(
                    'vehicle_type_id',
                    'Vehicle type and size count mismatch.'
                );
                return;
            }
        
            $combinations = [];
        
            foreach ($vehicleTypes as $index => $typeId) {
        
                $sizeId = $vehicleSizes[$index] ?? null;
        
                $key = $typeId . '-' . $sizeId;
        
                if (isset($combinations[$key])) {
                    $validator->errors()->add(
                        "vehicle_type_id.$index",
                        'Duplicate vehicle type and size combination.'
                    );
                }
        
                $combinations[$key] = true;
            }
        });
        
        
    
        $validator->after(function ($validator) use ($request) {

            $count = (int) $request->midpoint_count; 
        
            if ($count > 0) {  // \Log::info('Midpoint Count:', ['count' => $count]);
        
                $midpointTypes = $request->midpoint_type ?? [];
        
                // midpoint_type must exist
                if (empty($midpointTypes)) {
                    $validator->errors()->add('midpoint_type', 'Midpoint type is required.');
                    return;
                }
        
                // Array count must match midpoint_count
                if (count($midpointTypes) != $count) {
                    $validator->errors()->add('midpoint_type', 'Midpoint count mismatch.');
                }
        
                // Validate each index
                foreach ($midpointTypes as $index => $type) {
        
                    if (empty($type)) {
                        $validator->errors()->add(
                            "midpoint_type.$index",
                            "Please select midpoint type."
                        );
                        continue;
                    }
        
                    if ($type === 'Loading') {
        
                        if (empty($request->loading_midpoint[$index])) {
                            $validator->errors()->add(
                                "loading_midpoint.$index",
                                "Please select loading midpoint."
                            );
                        }
        
                    }
        
                    if ($type === 'Unloading') {
        
                        if (empty($request->unloading_midpoint[$index])) {
                            $validator->errors()->add(
                                "unloading_midpoint.$index",
                                "Please select unloading midpoint."
                            );
                        }
        
                    }
                }
            }
        });




        if ($validator->fails()) {
            \Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                'input' => request()->all(),
            ]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.'
            ], 422);
        }
        
        // Prevent same source & destination
        if ($request->contract_source_city_id == $request->contract_destination_city_id) {
            return response()->json([
                'success' => false,
                'message' => 'Source and destination cannot be same.'
            ], 422);
        }
        
        // Ensure vehicle arrays match
        if (count($request->vehicle_type_id) !== count($request->vehicletype_size_id) ||
            count($request->vehicle_type_id) !== count($request->vehicletype_price)) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle pricing arrays mismatch.'
            ], 422);
        }
        
        // Prevent duplicate pricing for same route
        $exists = Contractpricing::where([
            'contact_id' => $request->contact_id,
            'customercontract_id' => $request->customercontract_id,
            'customercontract_route_id' => $request->customercontract_route_id,
        ])->exists();
        
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Pricing already exists for this route.'
            ], 422);
        }
        
        
    
        try {
            
            
            $contractpricing = DB::transaction(function () use ($request) {
                
                $contractpricing  = new Contractpricing;
                $contractpricing->contact_id    = $request->contact_id;
                $contractpricing->customercontract_id  = $request->customercontract_id;
                $contractpricing->customercontract_route_id  = $request->customercontract_route_id;
                $contractpricing->applicable_start_date     = $request->applicable_start_date;
                $contractpricing->applicable_end_date       = $request->applicable_end_date;
                $contractpricing->retrospective_start_date  = $request->retrospective_start_date;
                $contractpricing->retrospective_end_date    = $request->retrospective_end_date;
                $contractpricing->created_by = Auth::user()->id;
                $contractpricing->save();
                
                // Log 
                $contractpricinglog  = new Contractpricinglog;
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
                $contractpricinglocationloadingpoint  = new Contractpricinglocationpoint;
                $contractpricinglocationloadingpoint->contractpricing_id = $contractpricing->id;
                $contractpricinglocationloadingpoint->point_type = 'Source';
                $contractpricinglocationloadingpoint->location_type = 'Loading';
                $contractpricinglocationloadingpoint->customerlocation_id = $request->contract_source_city_id;
                $contractpricinglocationloadingpoint->save();
                
                // Source Loading Point Log
                $contractpricinglocationloadingpointlog  = new Contractpricinglocationpointlog;
                $contractpricinglocationloadingpointlog->contractpricinglog_id = $contractpricinglog->id;
                $contractpricinglocationloadingpointlog->point_type = 'Source';
                $contractpricinglocationloadingpointlog->location_type = 'Loading';
                $contractpricinglocationloadingpointlog->customerlocation_id = $request->contract_source_city_id;
                $contractpricinglocationloadingpointlog->save();
                                
                
                // Destination Unloading Point
                $contractpricinglocationunloadingpoint  = new Contractpricinglocationpoint;
                $contractpricinglocationunloadingpoint->contractpricing_id = $contractpricing->id;
                $contractpricinglocationunloadingpoint->point_type = 'Destination';
                $contractpricinglocationunloadingpoint->location_type = 'Unloading';
                $contractpricinglocationunloadingpoint->customerlocation_id = $request->contract_destination_city_id;
                $contractpricinglocationunloadingpoint->save();
                
                // Destination Loading Point Log
                $contractpricinglocationunloadingpointlog  = new Contractpricinglocationpointlog;
                $contractpricinglocationunloadingpointlog->contractpricinglog_id = $contractpricinglog->id;
                $contractpricinglocationunloadingpointlog->point_type = 'Destination';
                $contractpricinglocationunloadingpointlog->location_type = 'Unloading';
                $contractpricinglocationunloadingpointlog->customerlocation_id = $request->contract_destination_city_id;
                $contractpricinglocationunloadingpointlog->save();
                
                
                // Insert Midpoints (if any)
                if ($request->midpoint_count) {

                    for ($i = 1; $i <= $request->midpoint_count; $i++) {
        
                        if (!empty($request->midpoint_type[$i])) {
        
                            $type = $request->midpoint_type[$i];
        
                            $location_id = null;
        
                            if ($type === 'Loading') {
                                $location_id = $request->loading_midpoint[$i] ?? null;
                            }
        
                            if ($type === 'Unloading') {
                                $location_id = $request->unloading_midpoint[$i] ?? null;
                            }
        
                            if ($location_id) {
                                $contractpricinglocationmidpoint  = new Contractpricinglocationpoint;
                                $contractpricinglocationmidpoint->contractpricing_id = $contractpricing->id;
                                $contractpricinglocationmidpoint->point_type = 'Midpoint';
                                $contractpricinglocationmidpoint->location_type = $type;
                                $contractpricinglocationmidpoint->customerlocation_id = $location_id;
                                $contractpricinglocationmidpoint->save();
                                
                                // Log
                                $contractpricinglocationmidpointlog  = new Contractpricinglocationpointlog;
                                $contractpricinglocationmidpointlog->contractpricinglog_id = $contractpricinglog->id;
                                $contractpricinglocationmidpointlog->point_type = 'Midpoint';
                                $contractpricinglocationmidpointlog->location_type = $type;
                                $contractpricinglocationmidpointlog->customerlocation_id = $location_id;
                                $contractpricinglocationmidpointlog->save();
                            }
                        }
                    }
                }
                
                
                
                // Insert Vehicle Pricing
                if ($request->vehicle_type_id) {
                    foreach ($request->vehicle_type_id as $index => $vehicleTypeId) {
                        $contractpricingvehicle  = new Contractpricingvehicle;
                        $contractpricingvehicle->contractpricing_id  = $contractpricing->id;
                        $contractpricingvehicle->vehicletype_id      = $vehicleTypeId;
                        $contractpricingvehicle->vehicletypesize_id  = $request->vehicletype_size_id[$index];
                        $contractpricingvehicle->price               = $request->vehicletype_price[$index];
                        $contractpricingvehicle->weight              = $request->vehicletype_weight[$index];
                        $contractpricingvehicle->save();
                        
                        // Log
                        $contractpricingvehiclelog  = new Contractpricingvehiclelog;
                        $contractpricingvehiclelog->contractpricinglog_id  = $contractpricinglog->id;
                        $contractpricingvehiclelog->vehicletype_id      = $vehicleTypeId;
                        $contractpricingvehiclelog->vehicletypesize_id  = $request->vehicletype_size_id[$index];
                        $contractpricingvehiclelog->price               = $request->vehicletype_price[$index];
                        $contractpricingvehiclelog->weight              = $request->vehicletype_weight[$index];
                        $contractpricingvehiclelog->save();
                    }
                }
                
                return $contractpricing;
                
            });
            
            // Log activity
            if($contractpricing->id){
                $this->storeUseractivity(47, 3, Auth::user()->id, $contractpricing->id, 'Added new Contract pricing.');
            }
            
    
            return response()->json([
                'success' => true,
                'data'    => $contractpricing,
                'message' => 'Contract pricing saved successfully.'
            ]);
            
        } catch (\Throwable $e) {

            \Log::error('Contract pricing save failed', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
        
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $e->getMessage(),
            ], 500);
        }

    }
    
    
    public function deleteCustomerContractPricing(Request $request)
    {
        $location = Customerlocation::find($request->location_id);

        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'Location not found.'
            ], 404);
        }
        
        try {
            
            DB::transaction(function () use ($request, $location) {
                
                $location->delete();
                
                // Log activity For Delete
                $description = 'Deleted a Customer location.';
                $useractivity = $this->storeUseractivity(45, 6, Auth::user()->id, $request->location_id, $description);
            });
    
            return response()->json([
                'success' => true,
                'message' => 'Customer location deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    
    public function getLabourCharges($id)
    {
        try {
    
            $pricing = Contractpricing::with([
                'locationPoints.location',
                'createdBy'
            ])->findOrFail($id);
    
            $data = [];
    
            foreach ($pricing->locationPoints as $point) {
    
                if (!$point->location) {
                    continue;
                }
    
                $location = $point->location;
    
                $chargesPaidBy = $location->charges_paid_by ?? null;
                $cappingAmount = $location->capping_amount ?? 0;
    
                // Display text
                $paidByText = $chargesPaidBy ?? '-';
                if ($chargesPaidBy === 'Mixed') {
                    $paidByText = 'Mixed (Cap Amt: ' . number_format($cappingAmount, 2) . ')';
                }
    
                $amount = 0;
    
                //SOURCE (Loading only)
                if ($point->point_type === 'Source' && $point->location_type === 'Loading') {
    
                    if ($chargesPaidBy === 'SRL') {
                        $amount = $location->loading_charge ?? 0;
                    } elseif ($chargesPaidBy === 'Mixed') {
                        $amount = $location->loading_charge ?? 0;
                    }
    
                    $data[] = [
                        'loading_point'   => $location->location_name,
                        'unloading_point' => '-',
                        'paid_by'         => $paidByText,
                        'amount'          => number_format($amount, 2),
                    ];
                }
    
                //DESTINATION (Unloading only)
                if ($point->point_type === 'Destination' && $point->location_type === 'Unloading') {
    
                    if ($chargesPaidBy === 'SRL') {
                        $amount = $location->unloading_charge ?? 0;
                    } elseif ($chargesPaidBy === 'Mixed') {
                        $amount = $location->unloading_charge ?? 0;
                    }
    
                    $data[] = [
                        'loading_point'   => '-',
                        'unloading_point' => $location->location_name,
                        'paid_by'         => $paidByText,
                        'amount'          => number_format($amount, 2),
                    ];
                }
    
                //MIDPOINT (Loading + Unloading)
                if ($point->point_type === 'Midpoint') {
    
                    if ($point->location_type === 'Loading') {
    
                        if ($chargesPaidBy === 'SRL') {
                            $amount = $location->loading_charge ?? 0;
                        } elseif ($chargesPaidBy === 'Mixed') {
                            $amount = $location->loading_charge ?? 0;
                        }
    
                        $data[] = [
                            'loading_point'   => $location->location_name,
                            'unloading_point' => '-',
                            'paid_by'         => $paidByText,
                            'amount'          => number_format($amount, 2),
                        ];
                    }
    
                    if ($point->location_type === 'Unloading') {
    
                        if ($chargesPaidBy === 'SRL') {
                            $amount = $location->unloading_charge ?? 0;
                        } elseif ($chargesPaidBy === 'Mixed') {
                            $amount = $location->unloading_charge ?? 0;
                        }
    
                        $data[] = [
                            'loading_point'   => '-',
                            'unloading_point' => $location->location_name,
                            'paid_by'         => $paidByText,
                            'amount'          => number_format($amount, 2),
                        ];
                    }
                }
            }
    
            return response()->json([
                'success'    => true,
                'message'    => 'Data fetched successfully.',
                'updated_by' => $pricing->createdBy?->name ?? '-',
                'updated_on' => $pricing->updated_at
                                    ? $pricing->updated_at->format('d/m/Y')
                                    : '-',
                'data'       => $data
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    
    public function getVehicleFreight($id)
    {
        try {
    
            $pricing = Contractpricing::with('vehicles.vehicleTypeSize')
                    ->findOrFail($id);

            $data = [];
    
            foreach ($pricing->vehicles as $vehicle) {
    
                $size = $vehicle->vehicleTypeSize;
    
                $data[] = [
                    'size' => $size
                        ? $size->name . ' ' .
                          ($size->length ?? '') . ' * ' .
                          ($size->width ?? '') . ' * ' .
                          ($size->height ?? '')
                        : '-',
    
                    'freight' => number_format($vehicle->price ?? 0, 2)
                ];
            }
    
            return response()->json([
                'success' => true,
                'data'    => $data
            ]);
    
        } catch (\Exception $e) {
            
            \Log::error('Vehicle Freight Error', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
        
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function getPricingHistory($id)
    {
        try {
    
            $pricing = Contractpricing::with([
                'customerContract',
                'contractroute.route'
            ])->find($id);
    
            if (!$pricing) {
                return response()->json([
                    'status' => false,
                    'html' => '<div class="text-center">Invalid Contract</div>'
                ]);
            }
    
            $logs = Contractpricinglog::with([
                'createdBy',
                'locationLogs.location',
                'vehicleLogs.vehicleType',
                'vehicleLogs.vehicleTypeSize'
            ])
            ->where('contractpricing_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
    
            if ($logs->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'html' => '<div class="text-center">No History Found</div>'
                ]);
            }
    
            $html = '';
    
            /* ================= HEADER ================= */
    
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
    
            /* ================= LOG LOOP ================= */
    
            foreach ($logs as $log) {
    
                // Same logic as working screen
                $loadingPoint = $log->locationLogs
                    ->where('point_type', 'Source')
                    ->where('location_type', 'Loading')
                    ->first();
    
                $unloadingPoint = $log->locationLogs
                    ->where('point_type', 'Destination')
                    ->where('location_type', 'Unloading')
                    ->first();
    
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
                                <th>Current Freight (₹)</th>
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
                            <td>₹'.number_format($vehicle->price ?? 0, 2).'</td>
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
    
            return response()->json([
                'status' => true,
                'html' => $html
            ]);
    
        } catch (\Exception $exp) {
    
            \Log::error('Pricing History Error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
    
            return response()->json([
                'status' => false,
                'html' => '<div class="text-danger text-center">Something went wrong</div>'
            ]);
        }
    }


    
    
    // Customer Location Section ---------------------------------------------------------------------------------------------
    
    public function filterCustomerLocations(Request $request, $id)
    {
        $query = Customerlocation::with('sourceCity')->where('contact_id', $id);
        
        // \Log::info('Filter Locations Called', [
        //     'contact_id' => $id,
        //     'location_type' => $request->location_type
        // ]);
    
        if ($request->location_type) {
            $query->where('location_type', $request->location_type);
        }
    
        $locations = $query->get();
        
        // \Log::info('Locations Found', [
        //     'count' => $locations->count(),
        //     'location_type' => $request->location_type,
        //     //'data' => $locations->toArray()
        // ]);
    
        return view('contacts.customer.locations', compact('locations'))->render();
    }
    
    
    public function storeCustomerLocation(Request $request)
    {
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_CUSTOMER)->find($request->contact_id); 
    
        if (!$contact) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Customer not found!'
            ], 422);
        }
        
        
        // Remove spaces from phone numbers
        $request->merge([
            'onsite_contact_person_phone'     => str_replace(' ', '', $request->onsite_contact_person_phone),
            'onsite_contact_person_whatsapp'  => str_replace(' ', '', $request->onsite_contact_person_whatsapp),
        ]);
        
        $decimalRule = ['nullable', 'numeric', 'min:0', 'max:999999999999999.99999', 'regex:/^\d+(\.\d{1,5})?$/'];

        $locationType = $request->location_type;
        
            
    
        $validator = Validator::make($request->all(), [
            'company_name'        => 'required|max:100',
            'location_name'       => 'required|max:100',
            'location_type'       => 'required|in:Loading,Unloading,Both',
            'company_role'        => 'required|in:Consignor,Consignee',
            
            'route_type'          => 'required|in:source,destination,midpoint',
            
            'source_city_id'      => ['nullable','exists:cities,id',Rule::requiredIf($request->route_type === 'source')],
            'destination_city_id' => ['nullable','exists:cities,id',Rule::requiredIf($request->route_type === 'destination')],
            'midpoint_city_id'    => ['nullable','exists:cities,id',Rule::requiredIf($request->route_type === 'midpoint')],
            
            // Loading rules
            'loading_charge_type' => ['nullable', Rule::requiredIf(in_array($request->location_type, ['Loading', 'Both']))],
            'loading_charge'      => array_merge($decimalRule, [Rule::requiredIf(in_array($request->location_type, ['Loading', 'Both']))]),
                                
            
            // Unloading rules
            'unloading_charge_type' => ['nullable',Rule::requiredIf(in_array($request->location_type, ['Unloading', 'Both'])),],
            'unloading_charge'      => array_merge($decimalRule, [Rule::requiredIf(in_array($request->location_type, ['Unloading', 'Both'])),]),
            
    
            'address'             => 'required|max:100',
            'post_code'           => 'required|digits:6',
            
            // Charges Paid By
            'brone_by' => 'nullable|in:customer,srl,mixed',
            // Capping Amount (Required if Mixed)
            'capping_amount' => array_merge($decimalRule, [Rule::requiredIf($request->brone_by === 'mixed')]),
        
        
            'onsite_contact_person' => 'nullable|max:100',
            
            // Clean Indian phone validation
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
            ]
        );
    
    
        if ($validator->fails()) {
            //\Log::error('Validation failed', [
                //'errors' => $validator->errors()->toArray(),
                //'location_type' => $request->location_type,
               // 'input' => request()->all(), // optional: log the input data for context
            //]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.'
            ], 422);
        }
        
        
    
        try {
            
            
            DB::transaction(function () use ($request, $contact) {
                
                $phoneCode = getPhoneCode();
            
                //\Log::info('Current locale:', ['p' => $phoneCode]);
                
                $contactlocation  = new Customerlocation;
                $contactlocation->contact_id    = $request->contact_id;
                $contactlocation->company_name  = $request->company_name;
                $contactlocation->company_role  = $request->company_role;
                
                $types = [
                    'source'      => 'Source',
                    'destination' => 'Destination',
                    'midpoint'    => 'Midpoint',
                ];
                $contactlocation->route_type    = $types[$request->route_type] ?? null;
                
                $contactlocation->source_city_id      = $request->source_city_id;
                $contactlocation->destination_city_id = $request->destination_city_id;
                $contactlocation->midpoint_city_id    = $request->midpoint_city_id;
                
                $contactlocation->location_name  = $request->location_name;
                
                $contactlocation->location_type  = $request->location_type;
                $contactlocation->loading_charge_type = in_array($request->location_type, ['Loading', 'Both']) ? $request->loading_charge_type : null;
                $contactlocation->loading_charge = in_array($request->location_type, ['Loading', 'Both']) ? $request->loading_charge : 0;
                $contactlocation->unloading_charge_type = in_array($request->location_type, ['Unloading', 'Both']) ? $request->unloading_charge_type : null;
                $contactlocation->unloading_charge = in_array($request->location_type, ['Unloading', 'Both']) ? $request->unloading_charge : 0;
                
                $contactlocation->address  = $request->address;
                $contactlocation->zipcode  = $request->post_code;
                
                
                $broneBy = [
                    'customer'  => 'Customer',
                    'srl'       => 'SRL',
                    'mixed'     => 'Mixed',
                ];
                $contactlocation->charges_paid_by = $broneBy[$request->brone_by] ?? null;
                $contactlocation->capping_amount = $request->capping_amount ?? 0;
                
                $contactlocation->onsite_contact_person  = $request->onsite_contact_person;
                $contactlocation->onsite_contact_person_phone_code  = $request->onsite_contact_person_phone_code ?? $phoneCode;
                $contactlocation->onsite_contact_person_phone  = $request->onsite_contact_person_phone;
                $contactlocation->onsite_contact_person_whatsapp_code  = $request->onsite_contact_person_whatsapp_code ?? $phoneCode;
                $contactlocation->onsite_contact_person_whatsapp  = $request->onsite_contact_person_whatsapp;
                $contactlocation->map_location  = $request->map_location;
                $contactlocation->additional_info  = $request->additional_info;
                
                $contactlocation->created_by = Auth::user()->id;
                
                // \Log::info('About to save customer location', $contactlocation->toArray());
                
                $contactlocation->save();
                
                // \Log::info('Saved customer location ID', ['id' => $contactlocation->id]);
                
                // Log activity
                $this->storeUseractivity(45, 3, Auth::user()->id, $contact->id, 'Customer Updated [ID: ' . $contact->id . '].');
                
            });
    
            return response()->json([
                'success' => true,
                'data'    => $contact,
                'message' => 'Customer location saved successfully.'
            ]);
            
        } catch (\Throwable $e) {

            \Log::error('CustomerLocation save failed', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
        
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $e->getMessage(),
            ], 500);
        }

    }
    
    
    public function deleteCustomerLocation(Request $request)
    {
        $location = Customerlocation::find($request->location_id);

        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'Location not found.'
            ], 404);
        }
        
        try {
            
            DB::transaction(function () use ($request, $location) {
                
                $location->delete();
                
                // Log activity For Delete
                $description = 'Deleted a Customer location.';
                $useractivity = $this->storeUseractivity(45, 6, Auth::user()->id, $request->location_id, $description);
            });
    
            return response()->json([
                'success' => true,
                'message' => 'Customer location deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    
    public function getLocationMidpoints(Request $request)
    {
        try {
    
            $contact_id = $request->contact_id;
            $type = $request->type;

            \Log::info('Fetch midpoints request received', [
                'contact_id' => $contact_id,
                'type'       => $type,
            ]);

            
            $midpoints = Customerlocation::where('route_type', 'Midpoint')->where('contact_id', $contact_id)
                                            ->whereIn('location_type', [$type, 'Both'])->get();

            \Log::info('Midpoints fetched', [
                'count' => $midpoints->count(),
                'data'  => $midpoints->toArray()
            ]);


            return response()->json([
                'success' => true,
                'message' => 'Midpoints fetched successfully.',
                'data' => $midpoints
            ]);
    
        } catch (\Exception $e) {
    
            \Log::error('Error fetching midpoints: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while fetching midpoints.'
            ], 500);
        }
    }
    
    
    // Customer Vehicle Section ---------------------------------------------------------------------------------------------
    
    public function filterCustomerVehicles(Request $request, $id)
    {
        $query = Vehicleallocation::where('contact_id', $id);
        $vehicles = $query->get();
        
        return view('contacts.customer.vehicles', compact('vehicles'))->render();
    }
    
    
    public function storeCustomerVehicle(Request $request)
    {
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_CUSTOMER)->find($request->contact_id); 
    
        if (!$contact) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Customer not found!'
            ], 422);
        }
        
        
        $decimalRule = ['nullable', 'numeric', 'min:0', 'max:999999999999999.99999', 'regex:/^\d+(\.\d{1,5})?$/'];

        
        $validator = Validator::make($request->all(), [
            
            'contact_id'        => ['required', 'exists:contacts,id'],
            'vehicle_id'        => [
                                        'required',
                                        'exists:vehicles,id',
                                        function ($attribute, $value, $fail) use ($request) {
                                            //$exists = Vehicleallocation::where('vehicle_id', $value)->where('type', 'Customer')->whereNull('deleted_at')->exists();
                                            
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
                                                
                                                //$fail('This vehicle is already allocated to a customer.');
                                            }
                                        }
                                    ],
            
    
            'v_start_date' => ['required', 'date', 'before_or_equal:v_end_date'],
            'v_end_date'   => ['required', 'date', 'after_or_equal:v_start_date'],
            'v_allowed_km' => ['required', 'numeric', 'min:0'],
            'v_fixed_amount' => ['required', 'numeric', 'min:0'],
            'v_extra_amount_per_km' => ['required', 'numeric', 'min:0'],
            
        ], [
                'required' => 'This field is required.',
                'max'      => 'Maximum 100 characters allowed.',
                'exists'   => "This field's value is invalid.",
                'digits'   => 'Invalid format.',
                'distinct' => 'Duplicate value.',
                'email'    => 'This email is invalid.',
            ]
        );
    
    
        if ($validator->fails()) {
            //\Log::error('Validation failed', [
                //'errors' => $validator->errors()->toArray(),
                //'location_type' => $request->location_type,
               // 'input' => request()->all(), // optional: log the input data for context
            //]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.'
            ], 422);
        }
        
        
    
        try {
            
            
            DB::transaction(function () use ($request, $contact) {
                
                // Vehicle Allocation
                $vehicleAllocation  = new Vehicleallocation;
                $vehicleAllocation->contact_id  = $contact->id;
                $vehicleAllocation->type  = 'Customer';
                $vehicleAllocation->vehicle_id  = $request->vehicle_id;
                $vehicleAllocation->change_vehicle  = null;
                $vehicleAllocation->vehicle_change_reason  = null;
                $vehicleAllocation->km_allowed  = $request->v_allowed_km ?? 0;
                $vehicleAllocation->fixed_amount  = $request->v_fixed_amount ?? 0;
                $vehicleAllocation->extra_amount_per_km  = $request->v_extra_amount_per_km ?? 0;
                $vehicleAllocation->start_date  = $request->v_start_date;
                $vehicleAllocation->end_date  = $request->v_end_date;
                
                $vehicleAllocation->created_by  = Auth::user()->id;
                $vehicleAllocation->save();
                
                // Log activity
                //$this->storeUseractivity(45, 3, Auth::user()->id, $contact->id, 'Customer Updated [ID: ' . $contact->id . '].');
                
            });
    
            return response()->json([
                'success' => true,
                'data'    => $contact,
                'message' => 'Vehicle has been successfully allocated to the customer.'
            ]);
            
        } catch (\Throwable $e) {

            \Log::error('CustomerVehicle save failed', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
        
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $e->getMessage(),
            ], 500);
        }

    }


    
    
    // Employee Section ------------------------------------------------------------------------------------------------------
    
    public function employeeList(Request $request): View
    {
        $cotypeId = self::CONTACT_TYPE_EMPLOYEE;
        
        $cities = City::whereHas('state.country', function ($q) {
                            $q->where('iso2', 'IN');   
                        })->orderBy('name')->get();
                        
        $branches = Branch::where('status', 'Active')->orderBy('location')->get();
        
        
        // Filter 
        $search_name = $request->name;
        $search_branch = $request->branch;
        $search_worktype = $request->worktype;
        
        $contacts = Contact::query()->where('cotype_id', $cotypeId);

        // Filter by name
        if ($request->filled('name')) {
            $contacts->where('contact_name', 'like', '%' . $request->name . '%');
        }
        
        // Filter by branch (Office OR Service Center)
        if ($request->filled('branch')) {
            $contacts->where(function ($q) use ($request) {
                $q->where('office_branch_id', $request->branch)
                  ->orWhere('service_center_branch_id', $request->branch);
            });
        }
        
        // Filter by work type 
        if ($request->filled('worktype')) {
            $contacts->where('work_type', $request->worktype);
        }
        
    
        $contacts = $contacts
                            ->with('cotype', 'officeBranch', 'serviceCenterBranch')
                            ->orderBy('id', 'desc')
                            ->paginate(10)
                            ->withQueryString(); // keep filters while paginating
                            
                            
        $cotypes = Cotype::all();
        $cotype  = $cotypes->firstWhere('id', self::CONTACT_TYPE_EMPLOYEE);
        
        
        return view('contacts.employee.index', compact('contacts','cotype','cities','branches','search_name','search_branch','search_worktype')); 
       
    }
    
    public function createEmployee(Request $request){
        
        //echo organisation_name(); exit();
        //echo optional(Auth::user()?->organisation)->id; exit();
        
        $countries = Country::all();
        
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
                        
        $cotypes   = Cotype::all();
        $customerabouttype = Customerabouttype::orderBy('name')->get();
        $religions = Religion::orderBy('name')->get();
        $departments = Department::where('status', 'Active')->orderBy('name')->get();
        $designations = Designation::where('status', 'Active')->orderBy('name')->get();
        
        $roles = Role::whereNotIn('slug', ['superadmin', 'admin', 'employee'])->orderBy('name')->get();
        $branches = Branch::where('status', 'Active')->orderBy('location')->get();
        $jobranks = Jobrank::where('status', 'Active')->orderBy('name')->get();
        $skillsets = Skillset::where('status', 'Active')->orderBy('name')->get();
        $banks = Bank::orderBy('name')->get();
        
        $gsttreats = Gsttreat::all();
        $coattachtypes = Coattachtype::all();       
        $cotype        = $cotypes->firstWhere('id', self::CONTACT_TYPE_EMPLOYEE);
        
        
        return view('contacts.employee.create', compact(
                                                    'customerabouttype',
                                                    'countries',
                                                    'states',
                                                    'cotype',
                                                    'cotypes',
                                                    'gsttreats',
                                                    'coattachtypes',
                                                    'religions',
                                                    'departments',
                                                    'designations',
                                                    'cities',
                                                    'roles',
                                                    'branches',
                                                    'jobranks',
                                                    'skillsets',
                                                    'banks'
                                                ));
        
    }
    
    
    public function storeEmployee(Request $request){ 
        
        $request->merge([
            'phone'    => preg_replace('/\s+/', '', $request->phone),
            'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp),
        ]);


        $validate_phone = function ($attribute, $value, $fail) use ($request) {
            $code = $request->phone_code ?? getPhoneCode();
        
            if (!$code) {
                //$fail('Phone number required country code to be selected.');
            }
        
            if (Contact::where('phone', $value)->where('ph_prefix', $code)->exists()) {
                $fail('This phone number already exists.');
            }
        };
        
        $validate_whatsapp = function ($attribute, $value, $fail) use ($request) {
            if (!$value) return;
        
            $code = $request->whatsapp_code ?? getPhoneCode();
        
            if (!$code) {
                //$fail('WhatsApp number required country code to be selected.');
            }
        };

        
        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) use ($request) {
            $index = explode('.', $attribute)[1] ?? null;
            $code = $request->get('contact_person_ph_code')[$index];
            if($code === NULL){
                //$fail('Phone number required country code to be selected.');
            }
        };
        
        // if (User::where('email', $request->email)->exists()) {
        //     $fail('This email id already exists.');
        // }
        
        $validator = Validator::make($request->all(), [
            'contact_name'        => 'required|max:100',
            'contact_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            //'phone_code'           => 'nullable|exists:countries,ph_code',
            'phone'               => ['required','digits:10',$validate_phone],
            //'whatsapp_code'     => 'nullable|exists:countries,ph_code',
            'whatsapp'            => ['nullable','digits:10',$validate_whatsapp],
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
            
            
            'service_type'          => 'nullable|required_if:workType,Service Center|in:Administrative,Technical',
            
            'service_center_branch_id'      => 'nullable|required_if:workType,Service Center|exists:branches,id',
            'service_center_department_id'  => 'nullable|required_if:workType,Service Center|exists:departments,id',
            'service_center_designation_id' => 'nullable|required_if:workType,Service Center|exists:designations,id',
            'service_center_jobrank_id'     => 'nullable|required_if:workType,Service Center|exists:jobranks,id',
            'service_center_role_ids'       => 'nullable|required_if:workType,Service Center|array|min:1',
            'service_center_role_ids.*'     => 'exists:roles,id',
            
            
            'servicecenter_technical_skillset_ids' => [
                                                        'nullable',
                                                        'array',
                                                        'min:1',
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if (
                                                                $request->workType === 'Service Center' &&
                                                                $request->service_type === 'Technical' &&
                                                                empty($value)
                                                            ) {
                                                                $fail('Skill Set is required for Service Center (Technical).');
                                                            }
                                                        },
                                                    ],
            'servicecenter_technical_skillset_ids.*' => 'exists:skillsets,id',
            
            
            'tracking_group'                => 'required|in:Tracking A,Tracking B',
            'providentFund'                 => 'nullable|in:yes,no',
            'provident_fund_no'             => 'nullable|required_if:providentFund,yes|alpha_num|max:25',
            'comment'                       => 'nullable|string|max:100000',
            
            'contact_person_name'         => 'required|array|min:1',
            'contact_person_name.*'       => 'required|string|distinct|min:1',
            'contact_person_relation'     => 'nullable|array|min:1',
            'contact_person_relation.*'   => 'nullable|string|min:1',
            'contact_person_blood_group'  => 'nullable|array|min:1',
            'contact_person_blood_group.*'=> 'nullable|string|min:1',
            'contact_person_address'      => 'nullable|array|min:1',
            'contact_person_address.*'    => 'nullable|string|min:1',
            'contact_person_ph_code'      => 'nullable|array|min:1',
            //'contact_person_ph_code.*'    => 'nullable|string|exists:countries,ph_code',
            'contact_person_phone'        => 'required|array|min:1',
            'contact_person_phone.*'      => ['required','string','distinct',$validate_cp_phone],
            'contact_person_whatsapp_code'      => 'nullable|array|min:1',
            //'contact_person_whatsapp_code.*'    => 'nullable|string|exists:countries,ph_code',
            'contact_person_whatsapp'        => 'nullable|array|min:1',
            'contact_person_whatsapp.*'      => ['nullable','string','distinct',$validate_cp_phone],
            'contact_person_email'        => 'nullable|array|min:1',
            'contact_person_email.*'      => 'nullable|email:rfc,dns|distinct',
            
            'contact_person_comment'      => 'nullable|array|min:1',
            'contact_person_comment.*'    => 'nullable|string|distinct|min:1',
            
            
            'permanent_address'          => 'required|string|max:255',
            'permanent_addr_state_id'    => 'required|exists:states,id',
            'permanent_addr_city_id'     => 'nullable|exists:cities,id',
            'permanent_addr_postal_code' => 'required|digits:6',
            
            'present_address'            => 'required|string|max:255',
            'present_addr_state_id'      => 'required|exists:states,id',
            'present_addr_city_id'       => 'nullable|exists:cities,id',
            'present_addr_postal_code'   => 'required|digits:6',
            
            //------------------------------------------------------------------
            
            // 'coattachtypes'               => 'nullable|array|min:1',
            // 'coattachtypes.*'             => 'required|exists:coattachtypes,id',
            // 'coattachments'               => 'required|array|min:1',
            // 'coattachments.*'             => 'required|array|min:1',
            // 'coattachments.*.*'           => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
            
        ], [
                'required'             => 'This field is required.',
                'gstin.required_if'    => 'This field is required.',
                'contact_email.unique' => 'This email has already been taken.',
                'max'                  => 'Maximum 100 characters allowed.',
                'contact_comment.max'  => 'Maximum 255 characters allowed.',
                'exists'               => "This field's value is invalid.",
                'distinct'             => 'Duplicate value.',
                'email'                => 'This email is invalid.',
                // Custom field-specific messages:
                'phone.digits' => 'This field must contain 10 digits.',
                'whatsapp.digits' => 'This field must contain 10 digits.',
                'contact_person_phone.*.digits' => 'This field must contain 10 digits.',
                'contact_person_whatsapp.*.digits' => 'This field must contain 10 digits.',
            
                'contact_name.required' => 'This field is required.',
                'contact_name.max'      => 'This cannot exceed 100 characters.',
            ]
        );
        
        
        
        $errorcount = 0;
        $errors = [];
        
        // For ADD NEW → no previous attachments
        $attachtype_ids = [];
        
        $attachtypes = $request->attachtypes ?? [];
        $filesInput  = $request->file('files') ?? [];
        
        $max = max(count($attachtypes), count($filesInput));
        
        for ($key = 0; $key < $max; $key++) {
        
            $attachtype = $attachtypes[$key] ?? null;
            $files      = $filesInput[$key] ?? null;
        
            // BOTH EMPTY → OK
            if (empty($attachtype) && empty($files)) {
                continue;
            }
        
            // FILE GIVEN BUT TYPE MISSING
            if (!empty($files) && empty($attachtype)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['Document type is required.'];
                continue;
            }
        
            // TYPE GIVEN BUT FILE MISSING
            if (!empty($attachtype) && empty($files)) {
                $errorcount++;
                $errors['coattachments_'.$key] = ['Please upload file.'];
                continue;
            }
        
            // DUPLICATE TYPE IN SAME REQUEST
            if (in_array($attachtype, $attachtype_ids)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['You’ve already added this attachment type.'];
                continue;
            }
        
            // Store type so next rows can't repeat
            $attachtype_ids[] = $attachtype;
        
            // FILE VALIDATION
            if (!empty($files)) {
        
                if (count($files) > 2) {
                    $errorcount++;
                    $errors['coattachments_'.$key] = ['You cannot upload more than 2 files.'];
                }
        
                foreach ($files as $file) {
        
                    $extension = strtolower($file->getClientOriginalExtension());
                    $size      = $file->getSize();
        
                    if (!in_array($extension, ['jpg','jpeg','png','pdf'])) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File type must be jpg, jpeg, png or pdf.'];
                    }
        
                    if ($size > 2097152) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File size must not exceed 2MB.'];
                    }
                }
            }
        }
        
        
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            \Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                //'input' => request()->all(), 
            ]);
            
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
        
        try {
            
            $contact = [];
            
            DB::transaction(function () use ($request, &$contact) {
                
                $lastcontact = Contact::withTrashed()->orderBy('id', 'DESC')->first();
                if($lastcontact){
                    $lastcontactno = (int) $lastcontact->contactno;
                    $incr_lastcontact = $lastcontactno+1;
                    if(strlen($incr_lastcontact)<5){
                        $contactno = '0';
                        for($i = 0; $i<(5-strlen($incr_lastcontact)); $i++){
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
                //\Log::info('Current locale:', ['p' => $phoneCode]);
                
                
                $filename = null;
                if ($request->hasFile('contact_image')) {
                
                    $uploadPath = public_path('media' . DIRECTORY_SEPARATOR . 'contact');
                
                    // Create folder if not exists
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }
                
                    $file = $request->file('contact_image'); // single file
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'branch_' . time() . '_' . Str::random(6) . '.' . $extension;
                
                    // Move file
                    $file->move($uploadPath, $filename);
                }
                
                
            
                $contact  = new Contact;
                $contact->contactno       = $contactno;
                $contact->cotype_id       = self::CONTACT_TYPE_EMPLOYEE;
                $contact->organisation_id = optional(Auth::user()?->organisation)->id;
                
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
                
                $contact->skillset_ids = (
                                            $request->workType === 'Service Center' &&
                                            $request->service_type === 'Technical' &&
                                            !empty($request->servicecenter_technical_skillset_ids)
                                        )
                                        ? json_encode($request->servicecenter_technical_skillset_ids)
                                        : null;
                                        
                $contact->tracking_group     = $request->tracking_group;
                $contact->provident_fund_registered = $request->providentFund == 'yes' ? 'Yes' : 'No';
                $contact->provident_fund_no = $request->provident_fund_no;
                $contact->comment = strip_tags($request->comment);
                
                $contact->created_by         = Auth::user()->id;
                
                $contact->save();
                
                
                $newRoleIds = $request->workType === 'Office Work' ? ($request->office_role_ids ?? []) : ($request->service_center_role_ids ?? []);
                foreach ($newRoleIds as $roleId) {
                    $contactRole = new Contactrole;
                    $contactRole->contact_id = $contact->id;
                    $contactRole->role_id    = $roleId;
                    $contactRole->save();
                }
                
                
                
                // Contact Persons + Users
                $names = $request->get('contact_person_name', []);
                for ($i = 0; $i < count($names); $i++) {
                    $name  = $names[$i] ?? null;
                    $relation = $request->get('contact_person_relation')[$i] ?? null;
                    $blood_group = $request->get('contact_person_blood_group')[$i] ?? null;
                    $address = $request->get('contact_person_address')[$i] ?? null;
                    
                    
                    $ph_code = $request->get('contact_person_ph_code')[$i] ?? null;
                    $phone = $request->get('contact_person_phone')[$i] ?? null;
                    
                    $whatsapp_code = $request->get('contact_person_whatsapp_code')[$i] ?? null;
                    $whatsapp = $request->get('contact_person_whatsapp')[$i] ?? null;
                    
                    $email = $request->get('contact_person_email')[$i] ?? null;
                    $comment = $request->get('contact_person_comment')[$i] ?? null;
                
                    // Skip if name, email, and phone all are empty
                    if (empty($name) && empty($phone)) {
                        continue;
                    }
                    
                    // Always create related contact if name or phone/email present
                    $relatedContact = new Relcontact;
                    $relatedContact->contact_id   = $contact->id;
                    $relatedContact->name         = $name;
                    $relatedContact->relationship = $relation;
                    $relatedContact->blood_group  = $blood_group;
                    $relatedContact->address      = $address;
                    
                    $relatedContact->ph_prefix        = $ph_code ?? $phoneCode;
                    $relatedContact->phone            = $phone;
                    $relatedContact->whatsapp_prefix  = $whatsapp_code ?? $phoneCode;
                    $relatedContact->whatsapp         = $whatsapp;
                    
                    $relatedContact->email      = $email;
                    $relatedContact->comment    = $comment;
                    $relatedContact->created_by = Auth::user()->id;
                    $relatedContact->save();
                }


            
                // Create Permanent Address 
                if (
                    !empty($request->get('permanent_address')) ||
                    !empty($request->get('permanent_addr_state_id')) ||
                    !empty($request->get('permanent_addr_postal_code'))
                ) {
                    $co_address = new Coaddress; 
                    $co_address->contact_id      = $contact->id;
                    $co_address->type            = 'Permanent';
                    $co_address->address         = $request->get('permanent_address');
                    $co_address->state_id        = $request->get('permanent_addr_state_id');
                    $co_address->city_id         = $request->get('permanent_addr_city_id');
                    $co_address->zipcode         = $request->get('permanent_addr_postal_code');
                    $co_address->additional_info = $request->get('permanent_addr_additional_info');
                    $co_address->save();
                }
                
                
                // Create Present Address 
                if (
                    !empty($request->get('present_address')) ||
                    !empty($request->get('present_addr_state_id')) ||
                    !empty($request->get('present_addr_postal_code'))
                ) {
                    $co_address = new Coaddress; 
                    $co_address->contact_id      = $contact->id;
                    $co_address->type            = 'Present';
                    $co_address->address         = $request->get('present_address');
                    $co_address->state_id        = $request->get('present_addr_state_id');
                    $co_address->city_id         = $request->get('present_addr_city_id');
                    $co_address->zipcode         = $request->get('present_addr_postal_code');
                    $co_address->additional_info = $request->get('present_addr_additional_info');
                    $co_address->save();
                }
                
                
                
                $contactId = $contact->id;
                $roleIds  = $request->role_ids;
                // if ($request->role_ids) {
                //     foreach ($roleIds as $roleId) {
                //         $contactRole = new Contactrole;
                //         $contactRole->contact_id = $contact->id;
                //         $contactRole->role_id    = $roleId;
                //         $contactRole->save();
                //     }
                // }
                
                
                // Contactbank
                if (
                    !empty($request->get('bank_id')) 
                ) {
                    $contact_bank = new Contactbank; 
                    $contact_bank->contact_id        = $contact->id;
                    $contact_bank->bank_id           = $request->bank_id;
                    $contact_bank->account_number    = $request->account_number;
                    $contact_bank->beneficiary_name  = $request->beneficiary_name;
                    $contact_bank->ifsc_code         = $request->ifsc_code;
                    $contact_bank->upi_id            = $request->upi_id;
                    $contact_bank->save();
                }
                
                
                
                
                $attachtypes = $request->attachtypes;
                if(!empty($attachtypes)){
                    foreach($attachtypes as $key => $attachtype){
                        if(isset($request->file('files')[$key])){
                            $files = $request->file('files')[$key];
                            
                            foreach($files as $file){
                                $fileoriginalname = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();
                                $filesize = $file->getSize();

                                // Keep original extension
                                $filename = 'contact-attachment-'.Str::random(4).'_'.time().'.'.$extension;

                                $file->move(
                                    public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR),
                                    $filename
                                );
                                
                                
                                $contact_attachment = new Coattachment;
                                $contact_attachment->name              = $filename;
                                $contact_attachment->original_name     = $fileoriginalname;
                                $contact_attachment->file_size         = ($filesize/(1024 *1024));
                                $contact_attachment->coattachtype_id   = $attachtype;
                                $contact_attachment->created_by        = Auth::id();
                                $contact_attachment->contact_id        = $contact->id;
                                $contact_attachment->save();
                            }
                        }
                    } 
                }
                
                
                // Log activity
                $description = 'Added new employee contact with ID ' . $contact->id;
                $this->storeUseractivity(3, 3, Auth::user()->id, $contact->id, $description);

            });
        
        
            return response()->json([
                'success' => true,
                'data'    => $contact,
                'message' => 'Employee saved successfully.'
            ]);
            
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage()
            ]);
        }
    }
    
    
    
    public function editEmployee(Request $request, $id) 
    {
         $contact = Contact::with([
             'country.states',
             'state.cities',
             'relcontacts',
             'coaddresses',
             'bank',
             'employeeAssets',
             'assetLogs',
             'workExperiences',
             'salaries',
             'employeeExitDetail',
             'coattachments.coattachtype',
             'activities',
             'activities.createdBy',
         ])
         ->where('cotype_id',self::CONTACT_TYPE_EMPLOYEE)
         ->where('id',$id)
         ->first();
        
        
        $countries = Country::all();
        
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
                        
        $cotypes   = Cotype::all();
        $customerabouttype = Customerabouttype::orderBy('name')->get();
        $religions = Religion::orderBy('name')->get();
        $departments = Department::where('status', 'Active')->orderBy('name')->get();
        $designations = Designation::where('status', 'Active')->orderBy('name')->get();
        $contactroles = Contactrole::where('contact_id', $contact->id)->pluck('role_id')->toArray();
    
        $roles = Role::whereNotIn('slug', ['superadmin', 'admin', 'employee'])->orderBy('name')->get();
        $branches = Branch::where('status', 'Active')->orderBy('location')->get();
        $jobranks = Jobrank::where('status', 'Active')->orderBy('name')->get();
        $skillsets = Skillset::where('status', 'Active')->orderBy('name')->get();
        $banks = Bank::orderBy('name')->get();
        
        $gsttreats = Gsttreat::all();
        $coattachtypes = Coattachtype::all();       
        $cotype        = $cotypes->firstWhere('id', self::CONTACT_TYPE_EMPLOYEE);
        $assets        = Asset::where('status', 'Active')->orderBy('name')->get();
        
        
        // split addresses by type
        $permanentAddress = $contact->coaddresses->firstWhere('type', 'Permanent');
        $presentAddress   = $contact->coaddresses->firstWhere('type', 'Present');
        
        
        $totalMonths = 0;
        if ($contact->workExperiences && $contact->workExperiences->isNotEmpty()) {
            foreach ($contact->workExperiences as $exp) {
                if ($exp->employment_start_date && $exp->employment_end_date) {
                    $start = Carbon::parse($exp->employment_start_date);
                    $end   = Carbon::parse($exp->employment_end_date);
            
                    // Only add if end >= start
                    if ($end >= $start) {
                        $diffMonths = $start->diffInMonths($end);
                        $totalMonths += $diffMonths;
                    }
                }
            }
        }
        
        // Safe conversion to years and months
        $totalYears = $totalMonths > 0 ? floor($totalMonths / 12) : 0;
        $remainingMonths = $totalMonths > 0 ? $totalMonths % 12 : 0;
        
         
         //dd($contact);
         
         // Log activity
         $description = 'Retrieve a employee named '.$contact->contact_name.' to edit.';
         $useractivity = $this->storeUseractivity(3, 5, Auth::user()->id, $contact->id, $description);
         
         return view('contacts.employee.edit', compact(
                                                    'contact',
                                                    'customerabouttype',
                                                    'countries',
                                                    'states',
                                                    'cotype',
                                                    'cotypes',
                                                    'gsttreats',
                                                    'coattachtypes',
                                                    'religions',
                                                    'departments',
                                                    'designations',
                                                    'cities',
                                                    'roles',
                                                    'contactroles',
                                                    'branches',
                                                    'jobranks',
                                                    'skillsets',
                                                    'banks',
                                                    'assets',
                                                    'permanentAddress',
                                                    'presentAddress',
                                                    'totalYears',
                                                    'remainingMonths'
                                                ));
    }
    
    
    public function updateEmployee(Request $request, $id)
    {
        $request->merge([
            'phone'    => preg_replace('/\s+/', '', $request->phone),
            'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp),
            'email'    => $request->email !== null ? trim($request->email) : null,
        ]);


        $validate_phone = function ($attribute, $value, $fail) use ($request, $id) {
            $code = $request->phone_code;
        
            if (!$code) {
                $fail('Phone number required country code to be selected.');
                return;
            }
        
            $exists = Contact::where('phone', $value)
                ->where('ph_prefix', $code)
                ->where('id', '!=', $id)   // IMPORTANT
                ->exists();
        
            if ($exists) {
                $fail('This phone number already exists.');
            }
        };

        
        $validate_whatsapp = function ($attribute, $value, $fail) use ($request) {
            if (!$value) return;
        
            $code = $request->whatsapp_code ?? null;
        
            if (!$code) {
                $fail('WhatsApp number required country code to be selected.');
            }
        };

        
        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) use ($request) {
            $index = explode('.', $attribute)[1] ?? null;
            $code = $request->get('contact_person_ph_code')[$index];
            if($code === NULL){
                $fail('Phone number required country code to be selected.');
            }
        };
        
        // if (User::where('email', $request->email)->exists()) {
        //     $fail('This email id already exists.');
        // }
        
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_EMPLOYEE)->find($id);
    
        if (!$contact) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Customer not found.'
            ], 422);
        }
        
        
        $validator = Validator::make($request->all(), [
            'contact_name'        => 'required|max:100',
            'contact_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            //'phone_code'           => 'nullable|exists:countries,ph_code',
            'phone'               => ['required','digits:10',$validate_phone],
            //'whatsapp_code'     => 'nullable|exists:countries,ph_code',
            'whatsapp'            => ['nullable','digits:10',$validate_whatsapp],
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
            
            
            'service_type'          => 'nullable|required_if:workType,Service Center|in:Administrative,Technical',
            
            'service_center_branch_id'      => 'nullable|required_if:workType,Service Center|exists:branches,id',
            'service_center_department_id'  => 'nullable|required_if:workType,Service Center|exists:departments,id',
            'service_center_designation_id' => 'nullable|required_if:workType,Service Center|exists:designations,id',
            'service_center_jobrank_id'     => 'nullable|required_if:workType,Service Center|exists:jobranks,id',
            'service_center_role_ids'       => 'nullable|required_if:workType,Service Center|array|min:1',
            'service_center_role_ids.*'     => 'exists:roles,id',
            
            // 'servicecenter_technical_skillset_ids'   => 'nullable|required_if:workType,Service Center|array|min:1',
            // 'servicecenter_technical_skillset_ids.*' => 'exists:skillsets,id',
            
            'servicecenter_technical_skillset_ids' => [
                                                        'nullable',
                                                        'array',
                                                        'min:1',
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if (
                                                                $request->workType === 'Service Center' &&
                                                                $request->service_type === 'Technical' &&
                                                                empty($value)
                                                            ) {
                                                                $fail('Skill Set is required for Service Center (Technical).');
                                                            }
                                                        },
                                                    ],
            'servicecenter_technical_skillset_ids.*' => 'exists:skillsets,id',
            
            
            'tracking_group'    => 'required|in:Tracking A,Tracking B',
            'providentFund'     => 'nullable|in:yes,no',
            'provident_fund_no' => 'nullable|required_if:providentFund,yes|alpha_num|max:25',
            'comment'           => 'nullable|string|max:100000',
            'status'            => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'  => 'required_if:status,Blacklisted',
            
            
            'contact_person_name'         => 'required|array|min:1',
            'contact_person_name.*'       => 'required|string|distinct|min:1',
            'contact_person_relation'     => 'nullable|array|min:1',
            'contact_person_relation.*'   => 'nullable|string|min:1',
            'contact_person_blood_group'  => 'nullable|array|min:1',
            'contact_person_blood_group.*'=> 'nullable|string|min:1',
            'contact_person_address'      => 'nullable|array|min:1',
            'contact_person_address.*'    => 'nullable|string|min:1',
            'contact_person_ph_code'      => 'nullable|array|min:1',
            //'contact_person_ph_code.*'    => 'nullable|string|exists:countries,ph_code',
            'contact_person_phone'        => 'required|array|min:1',
            'contact_person_phone.*'      => ['required','string','distinct',$validate_cp_phone],
            'contact_person_whatsapp_code'      => 'nullable|array|min:1',
            //'contact_person_whatsapp_code.*'    => 'nullable|string|exists:countries,ph_code',
            'contact_person_whatsapp'        => 'nullable|array|min:1',
            'contact_person_whatsapp.*'      => ['nullable','string','distinct',$validate_cp_phone],
            'contact_person_email'        => 'nullable|array|min:1',
            'contact_person_email.*'      => 'nullable|email:rfc,dns|distinct',
            

            //'contact_person_email.*'      => 'nullable|email|distinct|unique:relcontacts,email',
            'contact_person_comment'      => 'nullable|array|min:1',
            'contact_person_comment.*'    => 'nullable|string|distinct|min:1',
            
            
            'permanent_address'          => 'required|string|max:255',
            'permanent_addr_state_id'    => 'required|exists:states,id',
            'permanent_addr_city_id'     => 'nullable|exists:cities,id',
            'permanent_addr_postal_code' => 'required|digits:6',
            
            'present_address'            => 'required|string|max:255',
            'present_addr_state_id'      => 'required|exists:states,id',
            'present_addr_city_id'       => 'nullable|exists:cities,id',
            'present_addr_postal_code'   => 'required|digits:6',
            
            //------------------------------------------------------------------
            
            // 'coattachtypes'               => 'nullable|array|min:1',
            // 'coattachtypes.*'             => 'required|exists:coattachtypes,id',
            // 'coattachments'               => 'required|array|min:1',
            // 'coattachments.*'             => 'required|array|min:1',
            // 'coattachments.*.*'           => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
            
        ], [
                'required'             => 'This field is required.',
                'gstin.required_if'    => 'This field is required.',
                'contact_email.unique' => 'This email has already been taken.',
                'max'                  => 'Maximum 100 characters allowed.',
                'contact_comment.max'  => 'Maximum 255 characters allowed.',
                'exists'               => "This field's value is invalid.",
                'distinct'             => 'Duplicate value.',
                'email'                => 'This email is invalid.',
                // Custom field-specific messages:
                'phone.digits' => 'This field must contain 10 digits.',
                'whatsapp.digits' => 'This field must contain 10 digits.',
                'contact_person_phone.*.digits' => 'This field must contain 10 digits.',
                'contact_person_whatsapp.*.digits' => 'This field must contain 10 digits.',
            
                'contact_name.required' => 'This field is required.',
                'contact_name.max'      => 'This cannot exceed 100 characters.',
            ]
        );
        
        
    
        $errorcount = 0;
        $errors = [];
        
        // Safe initialization (works even if no attachments exist)
        $attachtype_ids = [];
        if(isset($contact)){
            $attachtype_ids = $contact->coattachments->pluck('coattachtype_id')->toArray();
        }
        
        $attachtypes = $request->attachtypes ?? [];
        $filesInput  = $request->file('files') ?? [];
        
        $max = max(count($attachtypes), count($filesInput));
        
        for ($key = 0; $key < $max; $key++) {
        
            $attachtype = $attachtypes[$key] ?? null;
            $files      = $filesInput[$key] ?? null;
        
            // BOTH EMPTY → OK
            if (empty($attachtype) && empty($files)) {
                continue;
            }
        
            // FILE GIVEN BUT TYPE MISSING
            if (!empty($files) && empty($attachtype)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['Document type is required.'];
                continue;
            }
        
            // TYPE GIVEN BUT FILE MISSING
            if (!empty($attachtype) && empty($files)) {
                $errorcount++;
                $errors['coattachments_'.$key] = ['Please upload file.'];
                continue;
            }
        
            // DUPLICATE TYPE CHECK (only if any exist)
            if (!empty($attachtype_ids) && in_array($attachtype, $attachtype_ids)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['You’ve already added this attachment type.'];
                continue;
            }
        
            // Add to array so same request can't repeat type
            $attachtype_ids[] = $attachtype;
        
            // FILE VALIDATION
            if (!empty($files)) {
        
                if (count($files) > 2) {
                    $errorcount++;
                    $errors['coattachments_'.$key] = ['You cannot upload more than 2 files.'];
                }
        
                foreach ($files as $file) {
        
                    $extension = strtolower($file->getClientOriginalExtension());
                    $size      = $file->getSize();
        
                    if (!in_array($extension, ['jpg','jpeg','png','pdf'])) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File type must be jpg, jpeg, png or pdf.'];
                    }
        
                    if ($size > 2097152) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File size must not exceed 2MB.'];
                    }
                }
            }
        }
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            \Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                //'input' => request()->all(), 
            ]);
            
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
    
        try {
            
            
            DB::transaction(function () use ($request, $contact) {
                
                $phoneCode = getPhoneCode();
                //\Log::info('Current locale:', ['p' => $phoneCode]);
                
                $filename = $contact->contact_image;
                if ($request->hasFile('contact_image')) {
                
                    $uploadPath = public_path('media' . DIRECTORY_SEPARATOR . 'contact');
                
                    // Create folder if not exists
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }
                
                    $file = $request->file('contact_image'); // single file
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'branch_' . time() . '_' . Str::random(6) . '.' . $extension;
                
                    // Move file
                    $file->move($uploadPath, $filename);
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
                
                $contact->skillset_ids = (
                                            $request->workType === 'Service Center' &&
                                            $request->service_type === 'Technical' &&
                                            !empty($request->servicecenter_technical_skillset_ids)
                                        )
                                        ? json_encode($request->servicecenter_technical_skillset_ids)
                                        : null;
                                        
                $contact->tracking_group     = $request->tracking_group;
                $contact->provident_fund_registered = $request->providentFund == 'yes' ? 'Yes' : 'No';
                $contact->provident_fund_no = $request->provident_fund_no;
                $contact->comment = $request->comment;
                
                $contact->status          = $request->get('status') ?? 'Active';
                $contact->blacklist_reason = $request->get('blacklist_reason') ?? null;
                
                if ($request->get('status') === 'Blacklisted') {
                    $contact->blacklisted_at = now();
                }else {
                    $contact->blacklisted_at = null;
                }
                                        
            
                $contact->updated_by      = Auth::user()->id;
                $contact->save();
                
                
                if ($request->filled('blacklist_reason')) {
                    $activity = new Contactactivity();
                    $activity->contact_id = $contact->id;
                    $activity->notes = $request->blacklist_reason; 
                    $activity->is_blacklisted = 'Yes';
                    $activity->created_by = Auth::user()->id;
                    $activity->save();
                }
                
                
                $newRoleIds = $request->workType === 'Office Work' ? ($request->office_role_ids ?? []) : ($request->service_center_role_ids ?? []);
                Contactrole::where('contact_id', $contact->id)->whereNotIn('role_id', $newRoleIds)->delete();
                foreach ($newRoleIds as $roleId) {

                    $role = Contactrole::withTrashed()->where('contact_id', $contact->id)->where('role_id', $roleId)->first();
                
                    if ($role) {
                        $role->restore(); // revive soft-deleted row
                    } else {
                        $contactRole = new Contactrole;
                        $contactRole->contact_id = $contact->id;
                        $contactRole->role_id    = $roleId;
                        $contactRole->save();
                    }
                }
                
                
    
                // === Update Relcontacts ===
                $relcontact_ids = [];

                foreach ($request->contact_person_name as $i => $name) {
                
                    $relatedContact = Relcontact::where('id', $request->contact_person_id[$i] ?? 0)
                                                ->where('contact_id', $contact->id)
                                                ->first();
                
                    if (!$relatedContact) {
                        $relatedContact = new Relcontact();
                        $relatedContact->contact_id = $contact->id;
                    }
                
                    $relatedContact->name         = $name;
                    $relatedContact->relationship = $request->contact_person_relation[$i] ?? null;
                    $relatedContact->blood_group  = $request->contact_person_blood_group[$i] ?? null;
                    $relatedContact->address      = $request->contact_person_address[$i] ?? null;
                
                    $relatedContact->ph_prefix        = $request->contact_person_ph_code[$i] ?? $phoneCode;
                    $relatedContact->phone            = $request->contact_person_phone[$i] ?? null;
                    $relatedContact->whatsapp_prefix  = $request->contact_person_whatsapp_code[$i] ?? $phoneCode;
                    $relatedContact->whatsapp         = $request->contact_person_whatsapp[$i] ?? null;
                
                    $relatedContact->email   = $request->contact_person_email[$i] ?? null;
                    $relatedContact->comment = $request->contact_person_comment[$i] ?? null;
                
                    $relatedContact->save();
                
                    $relcontact_ids[] = $relatedContact->id;
                }
                
                Relcontact::where('contact_id', $contact->id)->whereNotIn('id', $relcontact_ids)->delete();
                
    
                // === Update Billing Addresses ===
                Cobilling::where('contact_id', $contact->id)->delete();
                if (
                    !empty($request->get('billing_state_id')) ||
                    !empty($request->get('billing_city_id')) ||
                    !empty($request->get('billing_postalcode')) ||
                    !empty($request->get('billing_address')) ||
                    !empty($request->get('billing_additionalinfo'))
                ) {
                    $billing_address = new Cobilling;
                    $billing_address->country_id   = $request->billing_country;
                    $billing_address->state_id     = $request->billing_state_id;
                    $billing_address->city_id      = $request->billing_city_id;
                    $billing_address->address1     = $request->billing_address;
                    $billing_address->zipcode      = $request->billing_postalcode;
                    $billing_address->add_info     = $request->billing_additionalinfo;
                    $billing_address->contact_id   = $contact->id;
                    $billing_address->created_by   = Auth::user()->id;
                    $billing_address->save();
                }
    
                
                // === TODO: Handle Attachments (if needed) ===
                $attachtypes = $request->attachtypes;
                if(!empty($attachtypes)){
            
                    foreach($attachtypes as $key => $attachtype){
                        
                        if(isset($request->file('files')[$key])){
                            $files = $request->file('files')[$key];
                            
                            foreach($files as $file){
                                $fileoriginalname = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();
                                $filesize = $file->getSize();

                                // Keep original extension
                                $filename = 'contact-attachment-'.Str::random(4).'_'.time().'.'.$extension;

                                $file->move(
                                    public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR),
                                    $filename
                                );
                                
                                
                                $contact_attachment = new Coattachment;
                                $contact_attachment->name              = $filename;
                                $contact_attachment->original_name     = $fileoriginalname;
                                $contact_attachment->file_size         = ($filesize/(1024 *1024));
                                $contact_attachment->coattachtype_id   = $attachtype;
                                $contact_attachment->created_by        = Auth::id();
                                $contact_attachment->contact_id        = $contact->id;
                                $contact_attachment->save();
                            }
                            
                        }
                    } 
                }
                
                
                // Log activity
                $this->storeUseractivity(3, 4, Auth::user()->id, $contact->id, 'Employee Updated [ID: ' . $contact->id . '].');
                
            });
    
            return response()->json([
                'success' => true,
                'data'    => $contact,
                'message' => 'Employee updated successfully.'
            ]);
        } catch (\Exception $exp) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage()
            ]);
        }
    }
    
    
    
    public function storeEmployeeAsset(Request $request)
    {
        
        //$contact = Contact::where('cotype_id', self::CONTACT_TYPE_EMPLOYEE)->find($request->contact_id); 
        
        $contact = Contact::find($request->contact_id); 

        if (!$contact) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Employee not found!'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'asset_type' => 'required|in:Motor Vehicle,Electronics,Others', 
            'asset_id' => 'required|exists:assets,id'
        ]);
        
        if ($validator->fails()) {
            \Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                //'input' => request()->all(), // optional: log the input data for context
            ]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.',
            ], 422);
        }
        
        
        // Check duplicate
        $alreadyAssigned = Employeeasset::where('contact_id', $request->contact_id)->where('asset_id', $request->asset_id)->where('status', 'Assigned')->exists();
        if ($alreadyAssigned) {
            return response()->json([
                'success' => false,
                'message' => 'This asset is already assigned to this employee.',
            ], 422);
        }
            
            
        try {
            
            DB::transaction(function () use ($request, $contact) {
                
                $existingRecord = Employeeasset::where('contact_id', $request->contact_id)->where('asset_id', $request->asset_id)->where('status', 'Unassigned')->first();
                if ($existingRecord) {
                    $existingRecord->status = 'Assigned';
                    $existingRecord->revoke_date = null;
                    $existingRecord->comment = 'Reassigned asset.';
                    $existingRecord->created_by = Auth::user()->id;
                    $existingRecord->save();
                    
                    // $empAllotedAssetLog  = new Employeeallotedassetlog;
                    // $empAllotedAssetLog->employeeasset_id = $existingRecord->id;
                    // $empAllotedAssetLog->contact_id = $existingRecord->contact_id;
                    // $empAllotedAssetLog->asset_id   = $existingRecord->asset_id;
                    // $empAllotedAssetLog->status     = 'Assigned';
                    // $empAllotedAssetLog->comment    = 'Reassigned asset.';
                    // $empAllotedAssetLog->created_by = Auth::user()->id;
                    // $empAllotedAssetLog->save();
            
                    $empasset = $existingRecord;
                }else{
                    $empasset  = new Employeeasset;
                    $empasset->contact_id = $request->contact_id;
                    $empasset->asset_id   = $request->asset_id;
                    $empasset->status     = 'Assigned';
                    $empasset->comment    = 'Condition is okay.';
                    $empasset->created_by = Auth::user()->id;
                    $empasset->save();
                    
                    // $empAllotedAssetLog  = new Employeeallotedassetlog;
                    // $empAllotedAssetLog->employeeasset_id = $empasset->id;
                    // $empAllotedAssetLog->contact_id = $request->contact_id;
                    // $empAllotedAssetLog->asset_id   = $request->asset_id;
                    // $empAllotedAssetLog->status     = 'Assigned';
                    // $empAllotedAssetLog->comment    = 'Condition is okay.';
                    // $empAllotedAssetLog->created_by = Auth::user()->id;
                    // $empAllotedAssetLog->save();
                }
                
                // Log activity
                $description = 'Asset [ID: '.$request->asset_id.'] assigned to Employee [ID: '.$request->contact_id.']';
                $this->storeUseractivity(51, 3, Auth::user()->id, $empasset->id, $description);
                
            });
    
            return response()->json([
                'success' => true,
                'data'    => $contact,
                'message' => 'Asset assigned successfully.'
            ]);
            
            
        } catch (\Exception $e) {
    
            \Log::error($e->getMessage());
    
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
        
    }
    
    
    public function revokeEmployeeAsset(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'employeeasset_id' => 'required|exists:employeeassets,id',
            'revoke_date'      => 'required|date',
            'revoke_reason'    => 'required|string'
        ]);
        
        if ($validator->fails()) {
            //\Log::error('Validation failed', [
                //'errors' => $validator->errors()->toArray(),
                //'location_type' => $request->location_type,
               // 'input' => request()->all(), // optional: log the input data for context
            //]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.',
            ], 422);
        }
        
        
        $employeeAsset = Employeeasset::find($request->employeeasset_id);
        if (!$employeeAsset || $employeeAsset->status !== 'Assigned') {
            return response()->json([
                'success' => false,
                'message' => 'Asset is already revoked or not found.'
            ], 422);
        }
            
            
        try {
            
            DB::transaction(function () use ($request, $employeeAsset) {
                
                // Update current assignment
                $employeeAsset->status = 'Unassigned';
                $employeeAsset->revoke_date = $request->revoke_date;
                $employeeAsset->comment     = $request->revoke_reason;
                $employeeAsset->save();
            
                // Insert revoke log
                $empAllotedAssetLog  = new Employeeallotedassetlog;
                $empAllotedAssetLog->employeeasset_id = $employeeAsset->id;
                $empAllotedAssetLog->contact_id  = $employeeAsset->contact_id;
                $empAllotedAssetLog->asset_id    = $employeeAsset->asset_id;
                $empAllotedAssetLog->status      = 'Unassigned';
                $empAllotedAssetLog->revoke_date = $request->revoke_date;
                $empAllotedAssetLog->comment     = $request->revoke_reason;
                $empAllotedAssetLog->created_by  = Auth::user()->id;
                $empAllotedAssetLog->save();
                
                
                // Log activity
                $description = 'Asset [ID: '.$employeeAsset->asset_id.'] revoked from Employee [ID: '.$employeeAsset->contact_id.']';
                $this->storeUseractivity(51, 3, Auth::user()->id, $employeeAsset->id, $description);
                
            });
    
            return response()->json([
                'success' => true,
                'data'    => $employeeAsset,
                'message' => 'Asset revoked successfully.'
            ]);
            
            
        } catch (\Exception $e) {
    
            \Log::error($e->getMessage());
    
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
        
    }
    
    
    
    public function storeEmployeeWorkExperience(Request $request)
    {
        
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_EMPLOYEE)->find($request->contact_id); 

        if (!$contact) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Employee not found!'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'contact_id'                      => 'required|exists:contacts,id',
            'previous_company_name'           => 'required|max:255',
            'previous_designation'            => 'required|max:255', 
            'previous_employment_duration' => ['required', function ($attribute, $value, $fail) use ($request) {
                // Split input
                $dates = explode(' - ', $value);
            
                if (count($dates) !== 2) {
                    $fail('The employment duration format is invalid.');
                    return;
                }
            
                try {
                    $start = Carbon::parse(trim($dates[0]))->format('Y-m-d');
                    $end   = Carbon::parse(trim($dates[1]))->format('Y-m-d');
                } catch (\Exception $e) {
                    $fail('The employment duration contains invalid dates.');
                    return;
                }
            
                if ($end > date('Y-m-d')) {
                    $fail('The end date cannot be a future date.');
                }
            
                if ($start > $end) {
                    $fail('The start date cannot be after the end date.');
                }
            
                // Check for overlapping date ranges (new_start <= existing_end AND new_end >= existing_start)
                $exists = Employeeworkexperience::where('contact_id', $request->contact_id)
                                                ->where('employment_start_date', '<=', $end)
                                                ->where('employment_end_date', '>=', $start)
                                                ->exists();
            
                if ($exists) {
                    $fail('This employment period overlaps with an existing experience.');
                }
            }],
            'previous_exit_reason'            => 'required|max:500',
            'previous_salary'                 => 'required|numeric|min:1',
            'previous_legal_case'             => 'required|in:Yes,No',
            'previous_legal_case_comment'     => 'required_if:previous_legal_case,Yes',
            
            'previous_city_id'                => 'required_if:previous_legal_case,Yes|nullable|exists:cities,id',
            'previous_police_station'         => 'required_if:previous_legal_case,Yes|nullable|string|max:255',

            'previous_notes'                  => 'required',
        ], [
            'required' => 'This field is required.',
            'max'      => 'Maximum 100 characters allowed.',
            'unique'   => 'This value already exists.',
            'numeric'  => 'Only numeric values are allowed.',
            'min'      => 'Value must be at least :min.',
            'max'      => 'Maximum allowed value is :max.',
            'in'       => 'Invalid selection.',
        ]);
        
        
        if ($validator->fails()) {
            \Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                //'input' => request()->all(), // optional: log the input data for context
            ]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.',
            ], 422);
        }
            
            
        try {
            
            $empWorkExp = null;
            
            DB::transaction(function () use ($request, $empWorkExp) {
                
                $startDate = null;
                $endDate   = null;
                if ($request->previous_employment_duration) {
                    // Split by " - " with spaces around the dash
                    $dates = explode(' - ', $request->previous_employment_duration);
                
                    if (count($dates) === 2) {
                        $startDate = Carbon::parse(trim($dates[0]))->format('Y-m-d');
                        $endDate   = Carbon::parse(trim($dates[1]))->format('Y-m-d');
                    }
                }
                
                $empWorkExp  = new Employeeworkexperience;
                $empWorkExp->contact_id = $request->contact_id;
                $empWorkExp->previous_company_name   = $request->previous_company_name;
                $empWorkExp->designation   = $request->previous_designation;
                $empWorkExp->employment_start_date   = $startDate;
                $empWorkExp->employment_end_date   = $endDate;
                $empWorkExp->exit_reason = $request->previous_exit_reason;
                $empWorkExp->salary = $request->previous_salary;
                $empWorkExp->any_legal_case = $request->previous_legal_case;
                $empWorkExp->comment_about_case = $request->previous_legal_case_comment;
                $empWorkExp->city_id = $request->previous_city_id;
                $empWorkExp->police_station = $request->previous_police_station;
                $empWorkExp->notes = $request->previous_notes;
                
                $empWorkExp->created_by = Auth::user()->id;
                $empWorkExp->save();
                
                // Log activity
                $description = 'Employee [ID: '.$request->contact_id.'] work experience added.';
                $this->storeUseractivity(52, 3, Auth::user()->id, $empWorkExp->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Work experience added successfully.';
    
        } catch (\Exception $exp) {
            
            \Log::error('Save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $empWorkExp, 'message' => $respmessage]);
        
    }
    
    
    
    public function storeEmployeeSalary(Request $request)
    {
        
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_EMPLOYEE)->find($request->contact_id); 

        if (!$contact) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Employee not found!'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'contact_id'          => 'required|exists:contacts,id',
            'basic_pay'           => 'required|numeric|min:1',
            'salary_per_work'     => 'required_if:service_type,Technical|numeric|min:1',
            'effective_from'      => 'required|date|before_or_equal:today|date_format:Y-m-d',
        ], [
            'required' => 'This field is required.',
            'max'      => 'Maximum 100 characters allowed.',
            'unique'   => 'This value already exists.',
            'numeric'  => 'Only numeric values are allowed.',
            'min'      => 'Value must be at least :min.',
            'max'      => 'Maximum allowed value is :max.',
            'in'       => 'Invalid selection.',
        ]);
        
        
        if ($validator->fails()) {
            \Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                //'input' => request()->all(), // optional: log the input data for context
            ]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.',
            ], 422);
        }
            
            
        try {
            
            $empSalary = null;
            
            DB::transaction(function () use ($request, $empSalary) {
                
                $empSalary  = new Employeesalary;
                $empSalary->contact_id      = $request->contact_id;
                $empSalary->basic_pay       = $request->basic_pay ?? 0;
                $empSalary->salary_per_work = $request->salary_per_work ?? 0;
                $empSalary->effective_from  = $request->effective_from;
                
                $empSalary->created_by = Auth::user()->id;
                $empSalary->save();
                
                // Log activity
                $description = 'Employee [ID: '.$request->contact_id.'] salary added.';
                $this->storeUseractivity(52, 3, Auth::user()->id, $empSalary->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Employee salary added successfully.';
    
        } catch (\Exception $exp) {
            
            \Log::error('Save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $empSalary, 'message' => $respmessage]);
        
    }
    
    
    
    public function storeEmployeeExitDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_id'  => 'required|exists:contacts,id',
            'exit_reason' => 'required|string',
            'exit_date'   => 'required|date|before_or_equal:today',
            'exit_feedback' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            
            // Log the errors
            // \Log::error('Employee exit validation failed', [
            //     'errors' => $validator->errors()->toArray(),
            //     'input'  => $request->all(),
            //     'user_id' => auth()->id()
            // ]);
    
    
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }
        
        
        if (Employeeexitdetail::where('contact_id', $request->contact_id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Exit details already exist for this employee.'
            ]);
        }
    
        
    
        try {
            
            $exitDetails = null;
            
            DB::transaction(function () use ($request, &$exitDetails) {
                
                $exitDetails = new Employeeexitdetail();
                $exitDetails->contact_id = $request->contact_id;
                $exitDetails->exit_reason = $request->exit_reason;
                $exitDetails->exit_date = $request->exit_date;
                $exitDetails->feedback = $request->exit_feedback;
                
                $exitDetails->created_by = Auth::user()->id;
                $exitDetails->save();
                
                // Log user activity
                //$this->storeUseractivity(42, 3, Auth::user()->id, $tollstation->id, 'Added new Toll Station.');
            });
            
            $success = true;
            $respmessage = 'Exit detail saved successfully.';
    
    
        } catch (\Exception $exp) {
            
            // \Log::error('Process save error', [
            //     'message' => $exp->getMessage(),
            //     'trace' => $exp->getTraceAsString()
            // ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $exitDetails, 'message' => $respmessage]);
    }
    
    
    
    public function getJoiningLetter($id){
        
        $contact = Contact::with([
             'organisation',
             'country.states',
             'state.cities',
             'relcontacts',
             'coaddresses',
             'bank',
             'employeeAssets',
             'assetLogs',
             'workExperiences',
             'salaries',
             'employeeExitDetail',
             'activities',
             'activities.createdBy',
         ])
         ->where('cotype_id',self::CONTACT_TYPE_EMPLOYEE)
         ->where('id',$id)
         ->firstOrFail();
         
        $departments = Department::orderBy('name')->get();
        
        return view('contacts.employee.joining-letter',compact('contact','departments'));
        
    }
    
    
    public function getExitLetter($id){
        
        $contact = Contact::with([
             'organisation',
             'country.states',
             'state.cities',
             'relcontacts',
             'coaddresses',
             'bank',
             'employeeAssets',
             'assetLogs',
             'workExperiences',
             'salaries',
             'employeeExitDetail',
             'activities',
             'activities.createdBy',
         ])
         ->where('cotype_id',self::CONTACT_TYPE_EMPLOYEE)
         ->where('id',$id)
         ->firstOrFail();
         
        $departments = Department::orderBy('name')->get();
        
        return view('contacts.employee.exit-letter',compact('contact','departments'));
    }
    
    
    
    public function updateLetterSeenStatus(Request $request)
    {
        try {
    
            $contact = Contact::findOrFail($request->contact_id);
    
            if ($request->type === 'joining-letter') {
                $contact->joining_letter_seen_status = $request->seen_status;
            }
    
            if ($request->type === 'exit-letter') {
                $contact->exit_letter_seen_status = $request->seen_status;
            }
    
            $contact->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Seen status updated successfully.'
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
    
    
    // Load Vendor (Broker) Section ------------------------------------------------------------------------------------------
    
    public function loadvendorList(Request $request): View
    {
        $cotypeId = self::CONTACT_TYPE_LOAD_VENDOR;
        
        
        // Filter 
        $search_name     = $request->name;
        $search_city     = $request->city;
        $search_size     = $request->size;
        $search_location = $request->location;
        $search_rag      = $request->rag;
        
        
        $contacts = Contact::query()->where('cotype_id', $cotypeId);

        // Filter by Name
        if ($request->filled('name')) {
            $contacts->where('contact_name', 'like', '%' . $request->name . '%');
        }
    
        // Filter by City
        if ($request->filled('city')) {
            $contacts->where('city_id', $request->city);
        }
    
        // Filter by Size
        if ($request->filled('size')) {
            $contacts->where('size', $request->size);
        }
        
        // Filter by RAG
        if ($request->filled('rag')) {
            $contacts->where('rag_status', $request->rag);
        }
        
        // Filter by Location (IMPORTANT FIX)
        if ($request->filled('location')) {
            $contacts->whereHas('loadvendorlocations', function ($q) use ($request) {
                $q->where('id', $request->location);
            });
        }
        
        // Load relationships
        $contacts = $contacts
            ->with([
                'cotype',
                'relcontacts',
                'loadvendorlocations'
            ])
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();
        
        
        
        $cotypes   = Cotype::all();
        $cotype    = $cotypes->firstWhere('id', self::CONTACT_TYPE_LOAD_VENDOR);
        
        $cities = City::whereHas('state.country', function ($q) {
                            $q->where('iso2', 'IN');   
                        })->orderBy('name')->get();
                        
        $locationNames = Loadvendorlocation::query()->whereNull('deleted_at')->whereNotNull('location_name')->distinct()->orderBy('location_name')->pluck('location_name', 'id');
                        
        
        //dd($contacts);
        
        return view('contacts.loadvendor.index', compact('contacts','cities','cotype','locationNames','search_name','search_city','search_size','search_location','search_rag')); 
       
    }
    
    
    public function createLoadvendor(Request $request){
        
        $countries = Country::all();
        
        $states = State::whereHas('country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
                        
                        
        $cotypes   = Cotype::all();
        $customerabouttype = Customerabouttype::orderBy('name')->get();
        
        $gsttreats = Gsttreat::all();
        $coattachtypes = Coattachtype::all();       
        $cotype        = $cotypes->firstWhere('id', self::CONTACT_TYPE_LOAD_VENDOR);
        
        return view('contacts.loadvendor.create',compact('customerabouttype','countries','states','cotype','cotypes','gsttreats','coattachtypes')); 
    }
    
    
    public function storeLoadvendor(Request $request){ 
        
        $request->merge([
            'phone'    => preg_replace('/\s+/', '', $request->phone),
            'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp),
        ]);


        $validate_phone = function ($attribute, $value, $fail) use ($request) {
            $code = $request->phone_code ?? getPhoneCode();
        
            if (!$code) {
                //$fail('Phone number required country code to be selected.');
            }
        
            if (Contact::where('phone', $value)->where('ph_prefix', $code)->exists()) {
                $fail('This phone number already exists.');
            }
        };
        
        $validate_whatsapp = function ($attribute, $value, $fail) use ($request) {
            if (!$value) return;
        
            $code = $request->whatsapp_code ?? getPhoneCode();
        
            if (!$code) {
                //$fail('WhatsApp number required country code to be selected.');
            }
        };

        
        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) use ($request) {
            $index = explode('.', $attribute)[1] ?? null;
            $code = $request->get('contact_person_ph_code')[$index];
            if($code === NULL){
                //$fail('Phone number required country code to be selected.');
            }
        };
        
        // if (User::where('email', $request->email)->exists()) {
        //     $fail('This email id already exists.');
        // }
        
        $validator = Validator::make($request->all(), [
            'company_name'        => 'required|max:100',
            'contact_name'        => 'required|max:100',
            'contact_code'        => 'required|max:100',
            'contact_alias'       => 'nullable|max:100',
            'email'               => 'nullable|email|unique:contacts,email',
            //'phone_code'        => 'nullable|exists:countries,ph_code',
            'phone'               => ['required','digits:10',$validate_phone],
            //'whatsapp_code'     => 'nullable|exists:countries,ph_code',
            'whatsapp'            => ['nullable','digits:10',$validate_whatsapp],
            'size'                => 'nullable|in:Small,Medium,Large',
            'status'              => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'    => 'required_if:status,Blacklisted',
            'rag_status'          => 'nullable|in:Red,Yellow,Green',
            'contact_comment'     => 'nullable|string|max:255',
            
            'contact_person_name'         => 'required|array|min:1',
            'contact_person_name.*'       => 'required|string|distinct|min:1',
            'contact_person_designation'  => 'required|array|min:1',
            'contact_person_designation.*'=> 'required|string|min:1',
            'contact_person_ph_code'      => 'nullable|array|min:1',
            //'contact_person_ph_code.*'       => 'nullable|string|exists:countries,ph_code',
            'contact_person_phone'             => 'required|array|min:1',
            'contact_person_phone.*'           => ['required','string','distinct',$validate_cp_phone],
            'contact_person_whatsapp_code'     => 'nullable|array|min:1',
            //'contact_person_whatsapp_code.*' => 'nullable|string|exists:countries,ph_code',
            'contact_person_whatsapp'          => 'nullable|array|min:1',
            'contact_person_whatsapp.*'        => ['nullable','string','distinct',$validate_cp_phone],
            'contact_person_email'             => 'nullable|array|min:1',
            'contact_person_email.*'           => 'nullable|email:rfc,dns|distinct',
            'contact_person_comment'           => 'nullable|array|min:1',
            'contact_person_comment.*'         => 'nullable|string|distinct|min:1',
            
            
            // Attachment validation
            'attachtypes' => 'nullable|array',
            'attachtypes.*' => 'nullable|exists:coattachtypes,id',
    
            'files' => 'nullable|array',
            'files.*' => 'nullable|array|max:2',
            'files.*.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',

            // 'coattachtypes'               => 'nullable|array|min:1',
            // 'coattachtypes.*'             => 'required|exists:coattachtypes,id',
            // 'coattachments'               => 'required|array|min:1',
            // 'coattachments.*'             => 'required|array|min:1',
            // 'coattachments.*.*'           => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
            
        ], [
                'required'             => 'This field is required.',
                'gstin.required_if'    => 'This field is required.',
                'contact_email.unique' => 'This email has already been taken.',
                'max'                  => 'Maximum 100 characters allowed.',
                'contact_comment.max'  => 'Maximum 255 characters allowed.',
                'exists'               => "This field's value is invalid.",
                'distinct'             => 'Duplicate value.',
                'email'                => 'This email is invalid.',
                // Custom field-specific messages:
                'phone.digits' => 'This field must contain 10 digits.',
                'whatsapp.digits' => 'This field must contain 10 digits.',
                'contact_person_phone.*.digits' => 'This field must contain 10 digits.',
                'contact_person_whatsapp.*.digits' => 'This field must contain 10 digits.',
            
                'contact_name.required' => 'This field is required.',
                'contact_name.max'      => 'This cannot exceed 100 characters.',
                
                
                'files.*.max' => 'You cannot upload more than 2 files.',
                'files.*.*.mimes' => 'File type must be jpg, jpeg, png or pdf.',
                'files.*.*.max' => 'File size must not exceed 2MB.',
            ]
        );
        
        
        $errorcount = 0;
        $errors = [];
        
        // For ADD NEW → no previous attachments
        $attachtype_ids = [];
        
        $attachtypes = $request->attachtypes ?? [];
        $filesInput  = $request->file('files') ?? [];
        
        $max = max(count($attachtypes), count($filesInput));
        
        for ($key = 0; $key < $max; $key++) {
        
            $attachtype = $attachtypes[$key] ?? null;
            $files      = $filesInput[$key] ?? null;
        
            // BOTH EMPTY → OK
            if (empty($attachtype) && empty($files)) {
                continue;
            }
        
            // FILE GIVEN BUT TYPE MISSING
            if (!empty($files) && empty($attachtype)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['Document type is required.'];
                continue;
            }
        
            // TYPE GIVEN BUT FILE MISSING
            if (!empty($attachtype) && empty($files)) {
                $errorcount++;
                $errors['coattachments_'.$key] = ['Please upload file.'];
                continue;
            }
        
            // DUPLICATE TYPE IN SAME REQUEST
            if (in_array($attachtype, $attachtype_ids)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['You’ve already added this attachment type.'];
                continue;
            }
        
            // Store type so next rows can't repeat
            $attachtype_ids[] = $attachtype;
        
            // FILE VALIDATION
            if (!empty($files)) {
        
                if (count($files) > 2) {
                    $errorcount++;
                    $errors['coattachments_'.$key] = ['You cannot upload more than 2 files.'];
                }
        
                foreach ($files as $file) {
        
                    $extension = strtolower($file->getClientOriginalExtension());
                    $size      = $file->getSize();
        
                    if (!in_array($extension, ['jpg','jpeg','png','pdf'])) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File type must be jpg, jpeg, png or pdf.'];
                    }
        
                    if ($size > 2097152) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File size must not exceed 2MB.'];
                    }
                }
            }
        }
        
        
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            // \Log::error('Validation failed', [
            //     'errors' => $validator->errors()->toArray(),
            //     //'input' => request()->all(), // optional: log the input data for context
            // ]);
            
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
        
        try {
            $contact = [];
            
            DB::transaction(function () use ($request, &$contact) {
                
                $lastcontact = Contact::withTrashed()->orderBy('id', 'DESC')->first();
                if($lastcontact){
                    $lastcontactno = $lastcontact->contactno;
                    $incr_lastcontact = $lastcontactno+1;
                    if(strlen($incr_lastcontact)<5){
                        $contactno = '0';
                        for($i = 0; $i<(5-strlen($incr_lastcontact)); $i++){
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
            
                //\Log::info('Current locale:', ['p' => $phoneCode]);
            
                $contact  = new Contact;
                $contact->contactno       = $contactno;
                $contact->cotype_id       = self::CONTACT_TYPE_LOAD_VENDOR;
                $contact->organisation_id = optional(Auth::user()?->organisation)->id;
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
                $contact->rag_status       = $request->get('rag_status') ?? null;
                $contact->comment          = $request->get('contact_comment');
                
                $contact->created_by         = Auth::user()->id;
                
                $contact->save();
                
                
                
                // Contact Persons + Users
                $names = $request->get('contact_person_name', []);
                for ($i = 0; $i < count($names); $i++) {
                    $name  = $names[$i] ?? null;
                    $designation = $request->get('contact_person_designation')[$i] ?? null;
                    $ph_code = $request->get('contact_person_ph_code')[$i] ?? null;
                    $phone = $request->get('contact_person_phone')[$i] ?? null;
                    
                    $whatsapp_code = $request->get('contact_person_whatsapp_code')[$i] ?? null;
                    $whatsapp = $request->get('contact_person_whatsapp')[$i] ?? null;
                    
                    $email = $request->get('contact_person_email')[$i] ?? null;
                    $comment = $request->get('contact_person_comment')[$i] ?? null;
                
                    // Skip if name, email, and phone all are empty
                    if (empty($name) && empty($email) && empty($phone)) {
                        continue;
                    }
                
                    // Always create related contact if name or phone/email present
                    $relatedContact = new Relcontact;
                    $relatedContact->contact_id = $contact->id;
                    $relatedContact->name       = $name;
                    $relatedContact->position   = $designation;
                    $relatedContact->ph_prefix  = $ph_code ?? $phoneCode;
                    $relatedContact->phone      = $phone;
                    $relatedContact->whatsapp_prefix  = $whatsapp_code ?? $phoneCode;
                    $relatedContact->whatsapp      = $whatsapp;
                    $relatedContact->email      = $email;
                    $relatedContact->comment    = $comment;
                    $relatedContact->created_by = Auth::user()->id;
                    $relatedContact->save();
                }


                
                $attachtypes = $request->attachtypes;
                if(!empty($attachtypes)){
                    foreach($attachtypes as $key => $attachtype){
                        if(isset($request->file('files')[$key])){
                            $files = $request->file('files')[$key];
                            
                            foreach($files as $file){
                                $fileoriginalname = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();
                                $filesize = $file->getSize();

                                // Keep original extension
                                $filename = 'contact-attachment-'.Str::random(4).'_'.time().'.'.$extension;

                                $file->move(
                                    public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR),
                                    $filename
                                );
                                
                                
                                $contact_attachment = new Coattachment;
                                $contact_attachment->name              = $filename;
                                $contact_attachment->original_name     = $fileoriginalname;
                                $contact_attachment->file_size         = ($filesize/(1024 *1024));
                                $contact_attachment->coattachtype_id   = $attachtype;
                                $contact_attachment->created_by        = Auth::id();
                                $contact_attachment->contact_id        = $contact->id;
                                $contact_attachment->save();
                            }
                        }
                    } 
                }
                
                
                // Log activity
                $description = 'Added new load vendor contact with ID ' . $contact->id;
                $this->storeUseractivity(4, 3, Auth::user()->id, $contact->id, $description);

            });
        
        
            return response()->json([
                'success' => true,
                'data'    => $contact,
                'message' => 'Load Vendor (Broker) saved successfully.'
            ]);
            
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage()
            ]);
        }
    }
    
    
    public function editLoadvendor(Request $request, $id) 
    {
        $contact = Contact::with([
             'country.states',
             'state.cities',
             'relcontacts',
             'cobilling',
             'cobilling.state.cities',
             'cobilling.country.states',
             'coattachments.coattachtype',
             'activities',
             'activities.createdBy',
         ])
         ->where('cotype_id',self::CONTACT_TYPE_LOAD_VENDOR)
         ->where('id',$id)
         ->first();
         
        //dd($contact);
        //dd($contact->customercontracts);
        
         
        $cotypes   = Cotype::all();
        $coattachtypes = Coattachtype::all();
        $customerabouttype = Customerabouttype::orderBy('name')->get();
        
         
        $cotype = $cotypes->firstWhere('id', self::CONTACT_TYPE_LOAD_VENDOR);
         
         
        $organisationId = optional(Auth::user()?->organisation)->id;
        
        // Unique source cities
        $routeSourceCities = Route::where('status', 'Active')->where('organisation_id', $organisationId)->whereNotNull('source_city_id')->with('sourceCity:id,name')->get()->pluck('sourceCity')->filter()->unique('id')->values();
        
        // Unique destination cities
        $routeDestCities = Route::where('status', 'Active')->where('organisation_id', $organisationId)->whereNotNull('destination_city_id')->with('destinationCity:id,name')->get()->pluck('destinationCity')->filter()->unique('id')->values();

        // Unique midpoints 
        $routeMidpointCities = Route::where('status', 'Active')->where('organisation_id', $organisationId)->whereHas('midpoints')->with('midpoints.city:id,name')->get()->pluck('midpoints')->flatten()->pluck('city')->filter()->unique('id')->values();
    
        
        
        $sourceLoadingPoints = Customerlocation::where('contact_id', $id)->where('route_type', 'source')->whereIn('location_type', ['Loading', 'Both'])->get();
        $destinationUnloadingPoints = Customerlocation::where('contact_id', $id)->where('route_type', 'destination')->whereIn('location_type', ['Unloading', 'Both'])->get();
        $midPoints = Customerlocation::where('contact_id', $id)->where('route_type', 'midpoint')->get();
        
        
  
        //dd($contractPricings);
         
        // Log activity
        $description = 'Retrieve a load vendor named '.$contact->contact_name.' to edit.';
        $useractivity = $this->storeUseractivity(4, 5, Auth::user()->id, $contact->id, $description);
         
        return view('contacts.loadvendor.edit', compact('customerabouttype','cotype','contact','cotypes','coattachtypes',
                                                     
                                                     'routeSourceCities',
                                                     'routeDestCities',
                                                     'routeMidpointCities',
                                                     
                                                     'sourceLoadingPoints',
                                                     'destinationUnloadingPoints',
                                                     'midPoints',
                                                    ));
                                                    
    }
    
    
    
    public function updateLoadvendor(Request $request, $id)
    {
        // === Clean phone numbers (intl-tel-input adds spaces) ===
        if ($request->has('phone')) {
            $request->merge([
                'phone' => preg_replace('/\s+/', '', $request->phone),
            ]);
        }
        
        if ($request->has('whatsapp')) {
            $request->merge([
                'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp),
            ]);
        }
        
        if ($request->has('contact_person_phone')) {
            $phones = $request->contact_person_phone;
            foreach ($phones as $k => $p) {
                $phones[$k] = preg_replace('/\s+/', '', $p);
            }
            $request->merge(['contact_person_phone' => $phones]);
        }

        
        $validate_phone = function (string $attribute, mixed $value, Closure $fail) use ($id) {

            // Always take phone code from helper (not from request)
            $code = getPhoneCode();
        
            if (!$code) {
                //$fail('Phone number requires a country code.');
            }
        
            if (
                Contact::where('phone', $value)
                    ->where('ph_prefix', $code)
                    ->where('id', '!=', $id)
                    ->exists()
            ) {
                $fail('This phone number already exists.');
            }
        };


    
        $validate_cp_email = function (string $attribute, mixed $value, Closure $fail) use ($request) {
            $index = explode('.', $attribute)[1] ?? null;
            $email = $value;
            $person_id = $request->input("contact_person_id.$index");
    
            if ($email && $email !== null) {
                $query = Contact::where('email', $email);
                if ($person_id) {
                    $query->where('id', '!=', $person_id);
                }
    
                if ($query->exists()) {
                    $fail("The email $email is already taken.");
                }
            }
        };
    
        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) {

            $code = getPhoneCode();
        
            if (!$code) {
                //$fail('Contact person phone number requires a country code.');
            }
        };

    
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_LOAD_VENDOR)->find($id);
    
        if (!$contact) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Customer not found.'
            ], 422);
        }
    
        $validator = Validator::make($request->all(), [
            'company_name'        => 'required|max:100',
            'contact_name'        => 'required|max:100',
            'contact_code'        => 'required|max:100',
            'contact_alias'       => 'nullable|max:100',
            'email'               => [
                                    'nullable',
                                    'email',
                                    Rule::unique('contacts', 'email')->ignore($id),
                                  ],
            //'phone_code'        => 'nullable|exists:countries,ph_code',
            'phone'               => ['required','digits:10',$validate_phone],
            //'whatsapp_code'     => 'nullable|exists:countries,ph_code',
            'whatsapp'            => ['nullable','digits:10',$validate_phone],
            'size'                => 'nullable|in:Small,Medium,Large',
            'status'              => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'    => 'required_if:status,Blacklisted',
            'rag_status'          => 'nullable|in:Red,Yellow,Green',
            'contact_comment'     => 'nullable|string|max:255',
            
            'contact_person_name'         => 'required|array|min:1',
            'contact_person_name.*'       => 'required|string|distinct|min:1',
            'contact_person_designation'  => 'required|array|min:1',
            'contact_person_designation.*'=> 'required|string|min:1',
            'contact_person_ph_code'      => 'nullable|array|min:1',
            //'contact_person_ph_code.*'       => 'nullable|string|exists:countries,ph_code',
            'contact_person_phone'             => 'required|array|min:1',
            'contact_person_phone.*'           => ['required','string','distinct',$validate_cp_phone],
            'contact_person_whatsapp_code'     => 'nullable|array|min:1',
            //'contact_person_whatsapp_code.*' => 'nullable|string|exists:countries,ph_code',
            'contact_person_whatsapp'          => 'nullable|array|min:1',
            'contact_person_whatsapp.*'        => ['nullable','string','distinct',$validate_cp_phone],
            'contact_person_email'             => 'nullable|array|min:1',
            'contact_person_email.*'           => 'nullable|email:rfc,dns|distinct',
            'contact_person_comment'           => 'nullable|array|min:1',
            'contact_person_comment.*'         => 'nullable|string|distinct|min:1',
            
            
            // 'coattachtypes'               => 'nullable|array|min:1',
            // 'coattachtypes.*'             => 'nullable|exists:coattachtypes,id',
            // 'coattachments'               => 'nullable|array|min:1',
            // 'coattachments.*'             => 'nullable|array|min:1',
            // 'coattachments.*.*'           => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
            // 'delete_coattachment_ids'     => 'sometimes|array|min:1',
            // 'delete_coattachment_ids.*'   => [
            //         'required',
            //          Rule::exists('coattachments','id')
            //          ->whereNull('deleted_at')
            //          ->where('contact_id',$contact->id)
            //  ]
        ], [
                'required'             => 'This field is required.',
                'gstin.required_if'    => 'This field is required.',
                'contact_email.unique' => 'This email has already been taken.',
                'max'                  => 'Maximum 100 characters allowed.',
                'contact_comment.max'  => 'Maximum 255 characters allowed.',
                'exists'               => "This field's value is invalid.",
                'distinct'             => 'Duplicate value.',
                'email'                => 'This email is invalid.',
                // Custom field-specific messages:
                'phone.digits' => 'This field must contain 10 digits.',
                'whatsapp.digits' => 'This field must contain 10 digits.',
                'contact_person_phone.*.digits' => 'This field must contain 10 digits.',
                'contact_person_whatsapp.*.digits' => 'This field must contain 10 digits.',
            
                'contact_name.required' => 'This field is required.',
                'contact_name.max'      => 'This cannot exceed 100 characters.',
            ]
        );
        
        
    
        $errorcount = 0;
        $errors = [];
        
        // Safe initialization (works even if no attachments exist)
        $attachtype_ids = [];
        if(isset($contact)){
            $attachtype_ids = $contact->coattachments->pluck('coattachtype_id')->toArray();
        }
        
        $attachtypes = $request->attachtypes ?? [];
        $filesInput  = $request->file('files') ?? [];
        
        $max = max(count($attachtypes), count($filesInput));
        
        for ($key = 0; $key < $max; $key++) {
        
            $attachtype = $attachtypes[$key] ?? null;
            $files      = $filesInput[$key] ?? null;
        
            // BOTH EMPTY → OK
            if (empty($attachtype) && empty($files)) {
                continue;
            }
        
            // FILE GIVEN BUT TYPE MISSING
            if (!empty($files) && empty($attachtype)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['Document type is required.'];
                continue;
            }
        
            // TYPE GIVEN BUT FILE MISSING
            if (!empty($attachtype) && empty($files)) {
                $errorcount++;
                $errors['coattachments_'.$key] = ['Please upload file.'];
                continue;
            }
        
            // DUPLICATE TYPE CHECK (only if any exist)
            if (!empty($attachtype_ids) && in_array($attachtype, $attachtype_ids)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['You’ve already added this attachment type.'];
                continue;
            }
        
            // Add to array so same request can't repeat type
            $attachtype_ids[] = $attachtype;
        
            // FILE VALIDATION
            if (!empty($files)) {
        
                if (count($files) > 2) {
                    $errorcount++;
                    $errors['coattachments_'.$key] = ['You cannot upload more than 2 files.'];
                }
        
                foreach ($files as $file) {
        
                    $extension = strtolower($file->getClientOriginalExtension());
                    $size      = $file->getSize();
        
                    if (!in_array($extension, ['jpg','jpeg','png','pdf'])) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File type must be jpg, jpeg, png or pdf.'];
                    }
        
                    if ($size > 2097152) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File size must not exceed 2MB.'];
                    }
                }
            }
        }
        
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            // \Log::error('Validation failed', [
            //     'errors' => $validator->errors()->toArray(),
            //     //'input' => request()->all(), // optional: log the input data for context
            // ]);
            
            
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
    
        try {
            
            
            DB::transaction(function () use ($request, $contact) {
                
                $phoneCode = getPhoneCode();
            
                //\Log::info('Current locale:', ['p' => $phoneCode]);
                
                
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
                }else {
                    $contact->blacklisted_at = null;
                }

                $contact->blacklist_reason = $request->get('blacklist_reason') ?? null;
                $contact->rag_status       = $request->get('rag_status') ?? null;
                $contact->comment          = $request->get('contact_comment');
                
                $contact->updated_by      = Auth::user()->id;
                $contact->save();
    
                // === Update Relcontacts ===
                $relcontact_ids = [];
                foreach ($request->contact_person_name ?? [] as $i => $name) {
                    $rel = Relcontact::find($request->contact_person_id[$i] ?? 0);
                    if (!$rel) {
                        $rel = new Relcontact();
                        $rel->contact_id = $contact->id;
                    }
                    
                    $ph_code = $request->get('contact_person_ph_code')[$i] ?? null;
                    $phone = $request->get('contact_person_phone')[$i] ?? null;
                    
                    $whatsapp_code = $request->get('contact_person_whatsapp_code')[$i] ?? null;
                    $whatsapp = $request->get('contact_person_whatsapp')[$i] ?? null;
                    
                    
                    $rel->name      = $name;
                    $rel->position  = $request->contact_person_designation[$i] ?? null;
                    $rel->ph_prefix = $ph_code ?? $phoneCode;
                    $rel->phone     = $request->contact_person_phone[$i] ?? null;
                    $rel->whatsapp_prefix = $whatsapp_code ?? $phoneCode;
                    $rel->whatsapp      = $request->contact_person_whatsapp[$i] ?? null;
                    $rel->email     = $request->contact_person_email[$i] ?? null;
                    $rel->comment   = $request->contact_person_comment[$i] ?? null;
                    $rel->save();
    
                    $relcontact_ids[] = $rel->id;
                }
    
                Relcontact::where('contact_id', $contact->id)
                          ->whereNotIn('id', $relcontact_ids)
                          ->delete();
                          
                          
                if ($request->filled('blacklist_reason')) {
                    $activity = new Contactactivity();
                    $activity->contact_id = $contact->id;
                    $activity->notes = $request->blacklist_reason; 
                    $activity->is_blacklisted = 'Yes';
                    $activity->created_by = Auth::user()->id;
                    $activity->save();
                }
    
                
                // === TODO: Handle Attachments (if needed) ===
                $attachtypes = $request->attachtypes;
                if(!empty($attachtypes)){
            
                    foreach($attachtypes as $key => $attachtype){
                        
                        if(isset($request->file('files')[$key])){
                            $files = $request->file('files')[$key];
                            
                            foreach($files as $file){
                                $fileoriginalname = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();
                                $filesize = $file->getSize();

                                // Keep original extension
                                $filename = 'contact-attachment-'.Str::random(4).'_'.time().'.'.$extension;

                                $file->move(
                                    public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR),
                                    $filename
                                );
                                
                                
                                $contact_attachment = new Coattachment;
                                $contact_attachment->name              = $filename;
                                $contact_attachment->original_name     = $fileoriginalname;
                                $contact_attachment->file_size         = ($filesize/(1024 *1024));
                                $contact_attachment->coattachtype_id   = $attachtype;
                                $contact_attachment->created_by        = Auth::id();
                                $contact_attachment->contact_id        = $contact->id;
                                $contact_attachment->save();
                            }
                            
                        }
                    } 
                }
                
                
                // Log activity
                $this->storeUseractivity(4, 4, Auth::user()->id, $contact->id, 'Load Vendor Updated [ID: ' . $contact->id . '].');
                
            });
    
            return response()->json([
                'success' => true,
                'data'    => $contact,
                'message' => 'Load Vendor updated successfully.'
            ]);
        } catch (\Exception $exp) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage()
            ]);
        }
    }
    
    
    // Load Vendor Location Section ---------------------------------------------------------------------------------------------
    
    public function filterLoadvendorLocations(Request $request, $id)
    {
        $query = Loadvendorlocation::with('sourceCity')->where('contact_id', $id);
        
        // \Log::info('Filter Loadvendor Locations Called', [
        //     'contact_id' => $id,
        //     'location_type' => $request->location_type
        // ]);
    
        if ($request->location_type) {
            $query->where('location_type', $request->location_type);
        }
    
        $locations = $query->get();
        
        // \Log::info('Locations Found', [
        //     'count' => $locations->count(),
        //     'location_type' => $request->location_type,
        //     //'data' => $locations->toArray()
        // ]);
    
        return view('contacts.loadvendor.locations', compact('locations'))->render();
    }
    
    public function storeLoadvendorLocation(Request $request)
    {
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_LOAD_VENDOR)->find($request->contact_id); 
    
        if (!$contact) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Load vendor not found!'
            ], 422);
        }
        
        
        // Remove spaces from phone numbers
        $request->merge([
            'onsite_contact_person_phone'     => str_replace(' ', '', $request->onsite_contact_person_phone),
            'onsite_contact_person_whatsapp'  => str_replace(' ', '', $request->onsite_contact_person_whatsapp),
        ]);
        
        $decimalRule = ['nullable', 'numeric', 'min:0', 'max:999999999999999.99999', 'regex:/^\d+(\.\d{1,5})?$/'];

        $locationType = $request->location_type;
        
            
    
        $validator = Validator::make($request->all(), [
            'company_name'        => 'required|max:100',
            'location_name'       => 'required|max:100',
            'location_type'       => 'required|in:Loading,Unloading,Both',
            'company_role'        => 'required|in:Consignor,Consignee',
            
            'route_type'          => 'required|in:source,destination,midpoint',
            
            'source_city_id'      => ['nullable','exists:cities,id',Rule::requiredIf($request->route_type === 'source')],
            'destination_city_id' => ['nullable','exists:cities,id',Rule::requiredIf($request->route_type === 'destination')],
            'midpoint_city_id'    => ['nullable','exists:cities,id',Rule::requiredIf($request->route_type === 'midpoint')],
            
            // Loading rules
            'loading_charge_type' => ['nullable', Rule::requiredIf(in_array($request->location_type, ['Loading', 'Both']))],
            'loading_charge'      => array_merge($decimalRule, [Rule::requiredIf(in_array($request->location_type, ['Loading', 'Both']))]),
                                
            
            // Unloading rules
            'unloading_charge_type' => ['nullable',Rule::requiredIf(in_array($request->location_type, ['Unloading', 'Both'])),],
            'unloading_charge'      => array_merge($decimalRule, [Rule::requiredIf(in_array($request->location_type, ['Unloading', 'Both'])),]),
            
    
            'address'             => 'required|max:100',
            'post_code'           => 'required|digits:6',
            
            // Charges Paid By
            'brone_by' => 'nullable|in:loadvendor,srl,mixed',
            // Capping Amount (Required if Mixed)
            'capping_amount' => array_merge($decimalRule, [Rule::requiredIf($request->brone_by === 'mixed')]),
        
        
            'onsite_contact_person' => 'nullable|max:100',
            
            // Clean Indian phone validation
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
        
                'post_code.digits' => 'Postal code must be exactly 6 digits.',
        
                'location_type.required' => 'Please select a Location Type.',
            ]
        );
    
    
        if ($validator->fails()) {
            \Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                'location_type' => $request->location_type,
                //'input' => request()->all(), // optional: log the input data for context
            ]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.'
            ], 422);
        }
        
        
    
        try {
            
            
            DB::transaction(function () use ($request, $contact) {
                
                $phoneCode = getPhoneCode();
            
                //\Log::info('Current locale:', ['p' => $phoneCode]);
                
                $loadvendorlocation  = new Loadvendorlocation;
                $loadvendorlocation->contact_id    = $request->contact_id;
                $loadvendorlocation->company_name  = $request->company_name;
                $loadvendorlocation->company_role  = $request->company_role;
                
                $types = [
                    'source'      => 'Source',
                    'destination' => 'Destination',
                    'midpoint'    => 'Midpoint',
                ];
                $loadvendorlocation->route_type    = $types[$request->route_type] ?? null;
                
                $loadvendorlocation->source_city_id      = $request->source_city_id;
                $loadvendorlocation->destination_city_id = $request->destination_city_id;
                $loadvendorlocation->midpoint_city_id    = $request->midpoint_city_id;
                
                $loadvendorlocation->location_name  = $request->location_name;
                
                $loadvendorlocation->location_type  = $request->location_type;
                $loadvendorlocation->loading_charge_type = in_array($request->location_type, ['Loading', 'Both']) ? $request->loading_charge_type : null;
                $loadvendorlocation->loading_charge = in_array($request->location_type, ['Loading', 'Both']) ? $request->loading_charge : 0;
                $loadvendorlocation->unloading_charge_type = in_array($request->location_type, ['Unloading', 'Both']) ? $request->unloading_charge_type : null;
                $loadvendorlocation->unloading_charge = in_array($request->location_type, ['Unloading', 'Both']) ? $request->unloading_charge : 0;
                
                $loadvendorlocation->address  = $request->address;
                $loadvendorlocation->zipcode  = $request->post_code;
                
                
                $broneBy = [
                    'loadvendor' => 'Load Vendor',
                    'srl'        => 'SRL',
                    'mixed'      => 'Mixed',
                ];
                $loadvendorlocation->charges_paid_by = $broneBy[$request->brone_by] ?? null;
                $loadvendorlocation->capping_amount = $request->capping_amount ?? 0;
                
                $loadvendorlocation->onsite_contact_person  = $request->onsite_contact_person;
                $loadvendorlocation->onsite_contact_person_phone_code  = $request->onsite_contact_person_phone_code ?? $phoneCode;
                $loadvendorlocation->onsite_contact_person_phone  = $request->onsite_contact_person_phone;
                $loadvendorlocation->onsite_contact_person_whatsapp_code  = $request->onsite_contact_person_whatsapp_code ?? $phoneCode;
                $loadvendorlocation->onsite_contact_person_whatsapp  = $request->onsite_contact_person_whatsapp;
                $loadvendorlocation->map_location  = $request->map_location;
                $loadvendorlocation->additional_info  = $request->additional_info;
                
                $loadvendorlocation->created_by = Auth::user()->id;
                
                // \Log::info('About to save customer location', $loadvendorlocation->toArray());
                
                $loadvendorlocation->save();
                
                // \Log::info('Saved customer location ID', ['id' => $loadvendorlocation->id]);
                
                // Log activity
                $this->storeUseractivity(53, 3, Auth::user()->id, $contact->id, 'Load vendor location added [ID: ' . $loadvendorlocation->id . '].');
                
            });
    
            return response()->json([
                'success' => true,
                'data'    => $contact,
                'message' => 'Load vendor location saved successfully.'
            ]);
            
        } catch (\Throwable $e) {

            \Log::error('Load vendor Location save failed', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
        
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $e->getMessage(),
            ], 500);
        }

    }
    
    
    public function deleteLoadvendorLocation(Request $request)
    {
        $location = Loadvendorlocation::find($request->location_id);

        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'Location not found.'
            ], 404);
        }
        
        try {
            
            DB::transaction(function () use ($request, $location) {
                
                $location->delete();
                
                // Log activity For Delete
                $description = 'Deleted a Customer location.';
                $useractivity = $this->storeUseractivity(45, 6, Auth::user()->id, $request->location_id, $description);
            });
    
            return response()->json([
                'success' => true,
                'message' => 'Customer location deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    
    public function getLoadvendorMidpoints(Request $request)
    {
        try {
    
            $contact_id = $request->contact_id;
            $type = $request->type;
    
            $midpoints = Loadvendorlocation::where('route_type', 'midpoint')->where('contact_id', $contact_id)->where('location_type', $type)->get();
    
            return response()->json([
                'success' => true,
                'message' => 'Midpoints fetched successfully.',
                'data' => $midpoints
            ]);
    
        } catch (\Exception $e) {
    
            \Log::error('Error fetching midpoints: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while fetching midpoints.'
            ], 500);
        }
    }
    
    
    
    // Driver Section --------------------------------------------------------------------------------------------------------
    
    public function driverList(Request $request): View
    {
        $cotypeId = self::CONTACT_TYPE_DRIVER;
        
        
        // Filter 
        $search_name     = $request->name;
        $search_rag      = $request->rag;
        $search_category = $request->category;
        
        
        
        $contacts = Contact::query()->where('cotype_id', $cotypeId);

        // Filter by Name
        if ($request->filled('name')) {
            $contacts->where('contact_name', 'like', '%' . $request->name . '%');
        }
    
        // Filter by RAG
        if ($request->filled('rag')) {
            $contacts->where('rag_status', $request->rag);
        }
    
        // Filter by Driver Category (from driverinfos table)
        if ($request->filled('category')) {
            $contacts->whereHas('driverinfo', function ($q) use ($request) {
                $q->where('category', $request->category);
            });
        }
        
        
        // Load relationships
        $contacts = $contacts
                            ->with([
                                'cotype',
                                'relcontacts',
                                'driverinfo',
                                'currentVehicleAllocation.vehicle'
                            ])
                            ->orderBy('id', 'desc')
                            ->paginate(10)
                            ->withQueryString();
        
    
        
        $cotypes   = Cotype::all();
        $cotype    = $cotypes->firstWhere('id', self::CONTACT_TYPE_DRIVER);
        
        $cities = City::whereHas('state.country', function ($q) {
                            $q->where('iso2', 'IN');   
                        })->orderBy('name')->get();
                        
        
        //dd($contacts);
        
        
        return view('contacts.driver.index', compact('contacts','cities','cotype','search_name','search_category','search_rag')); 
       
    }
    
    
    public function createDriver(Request $request){
        //echo organisation_name(); exit();
        
        //echo optional(Auth::user()?->organisation)->id; exit();
        
        $countries = Country::all();
        
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
                        
        $cotypes   = Cotype::all();
        $customerabouttype = Customerabouttype::orderBy('name')->get();
        $religions = Religion::orderBy('name')->get();
        $departments = Department::where('status', 'Active')->orderBy('name')->get();
        $designations = Designation::where('status', 'Active')->orderBy('name')->get();
        
        $roles = Role::whereNotIn('slug', ['superadmin', 'admin', 'employee'])->orderBy('name')->get();
        $branches = Branch::where('status', 'Active')->orderBy('location')->get();
        $jobranks = Jobrank::where('status', 'Active')->orderBy('name')->get();
        $skillsets = Skillset::where('status', 'Active')->orderBy('name')->get();
        $banks = Bank::orderBy('name')->get();
        $vehicles = Vehicle::where('status', 'Active')->get(); 
        
        $gsttreats = Gsttreat::all();
        $coattachtypes = Coattachtype::all();       
        $cotype        = $cotypes->firstWhere('id', self::CONTACT_TYPE_DRIVER);
        
        $lastDriver = Contact::where('cotype_id',self::CONTACT_TYPE_DRIVER)->orderBy('id','desc')->first();
        if ($lastDriver) {
            $newNumber = $lastDriver->id + 1;
        } else {
            $newNumber = 1;
        }
        $driverCode = 'DR-' . $newNumber;
        
        
        return view('contacts.driver.create', compact(
                                                    'customerabouttype',
                                                    'countries',
                                                    'states',
                                                    'cotype',
                                                    'cotypes',
                                                    'gsttreats',
                                                    'coattachtypes',
                                                    'religions',
                                                    'departments',
                                                    'designations',
                                                    'cities',
                                                    'roles',
                                                    'branches',
                                                    'jobranks',
                                                    'skillsets',
                                                    'banks',
                                                    'vehicles',
                                                    'driverCode'
                                                ));
        
    }
    
    
    
    public function storeDriver(Request $request){ 
        
        $request->merge([
            'phone'    => preg_replace('/\s+/', '', $request->phone),
            'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp), 
            'guarantor_phone' => preg_replace('/\s+/', '', $request->guarantor_phone),
        ]);


        $validate_phone = function ($attribute, $value, $fail) use ($request) {
            $code = $request->phone_code ?? getPhoneCode();
        
            if (!$code) {
                //$fail('Phone number required country code to be selected.');
            }
        
            if (Contact::where('phone', $value)->where('ph_prefix', $code)->exists()) {
                $fail('This phone number already exists.');
            }
        };
        
        $validate_whatsapp = function ($attribute, $value, $fail) use ($request) {
            if (!$value) return;
        
            $code = $request->whatsapp_code ?? getPhoneCode();
        
            if (!$code) {
                //$fail('WhatsApp number required country code to be selected.');
            }
        };

        
        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) use ($request) {
            $index = explode('.', $attribute)[1] ?? null;
            $code = $request->get('contact_person_ph_code')[$index];
            if($code === NULL){
                //$fail('Phone number required country code to be selected.');
            }
        };
        
        // if (User::where('email', $request->email)->exists()) {
        //     $fail('This email id already exists.');
        // }
        
        $validator = Validator::make($request->all(), [
            //'licence_no'          => 'nullable',
            'contact_name'        => 'required|max:100',
            'contact_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'contact_code'        => 'required|max:100',
            'driver_category'     => 'required|in:Local,Line',
            
            'vehicle_id'          => [
                                        'required',
                                        'exists:vehicles,id',
                                        function ($attribute, $value, $fail) {
                                            $exists = Vehicleallocation::where('vehicle_id', $value)->where('type', 'Driver')->whereNull('deleted_at')->exists();
                                            if ($exists) {
                                                $fail('This vehicle is already allocated to a driver.');
                                            }
                                        }
                                    ],
            
            //'phone_code'        => 'nullable|exists:countries,ph_code',
            'phone'               => ['required','digits:10',$validate_phone],
            //'whatsapp_code'     => 'nullable|exists:countries,ph_code',
            'whatsapp'            => ['nullable','digits:10',$validate_whatsapp],
            
            'dob'                 => 'nullable|date_format:Y-m-d',
            'doj'                 => 'required|date|before_or_equal:today',
            'blood_group'         => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'religion_id'         => 'nullable|exists:religions,id',

            'driving_licence_no'  => 'required|string|max:255',
            'licence_issue_date'  => 'required|date_format:Y-m-d',
            'licence_expiry_date' => 'required|date_format:Y-m-d',
            'original_licence_location' => 'required|string|max:255',
            'driving_license_proof_file' => 'required|file|max:2048',

            'aadhaar_no' => 'required|string|max:255',
            'aadhaar_card_proof_file' => 'required|file|max:2048',
            'signed_driver_form_file' => 'required|file|max:2048',
            
            'status'              => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'    => 'required_if:status,Blacklisted',
            'status_type'         => 'nullable|required_if:status,Inactive|in:On Leave,Voluntary Exit',
            'expected_return_date'=> 'nullable|date|date_format:Y-m-d|required_if:status_type,On Leave|required_if:status,Inactive',
            'set_reminder'        => [
                                    'nullable',
                                    'in:Yes,No',
                                    Rule::requiredIf(function () use ($request) {
                                        return $request->status == 'Inactive' && $request->status_type == 'On Leave';
                                    }),
                                ],

            'rag_status'          => 'nullable|in:Red,Yellow,Green',
            
            'voluntary_exit_reason' => [
                                        'nullable',
                                        Rule::requiredIf(function () use ($request) {
                                            return $request->status == 'Inactive' && $request->status_type == 'Voluntary Exit';
                                        }),
                                    ],
                                    
            'vehicle_photos'    => [
                                    'nullable',
                                    'array',
                                    Rule::requiredIf(function () use ($request) {
                                        return $request->status == 'Inactive' && $request->status_type == 'Voluntary Exit';
                                    }),
                                ],

            'vehicle_photos.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            
            
            'hisab_category'       => 'required|in:Fixed,Fuel',
            'opening_balance_date' => 'required|date|date_format:Y-m-d',
            'opening_balance_type' => 'required|in:Credit,Debit',
            'opening_balance'      => 'required|numeric|min:0',
            'guarantor_name'    => 'required|string|max:255',
            'guarantor_phone'   => ['required','digits:10',$validate_phone],
            'contact_comment'   => 'nullable|string|max:255',
            
            
            'is_primary' => 'required|array',
            'is_primary.*' => 'required|in:Yes,No',
            
            'bank_id' => 'required|array',
            'bank_id.*' => 'required|exists:banks,id',
            
            'beneficiary_name' => 'nullable|array',
            'beneficiary_name.*' => 'nullable|string|max:255',
            
            'account_number' => 'required|array',
            'account_number.*' => 'required|string|max:50',

            
            'ifsc_code' => 'required|array',
            'ifsc_code.*' => 'required|string|max:20',
            
            'upi_id' => 'nullable|array',
            'upi_id.*' => 'nullable|string|max:100',
            
            
            
            'contact_person_name'         => 'required|array|min:1',
            'contact_person_name.*'       => 'required|string|distinct|min:1',
            'contact_person_relation'     => 'required|array|min:1',
            'contact_person_relation.*'   => 'required|string|min:1',
            'contact_person_blood_group'  => 'nullable|array|min:1',
            'contact_person_blood_group.*'=> 'nullable|string|min:1',
            'contact_person_address'      => 'nullable|array|min:1',
            'contact_person_address.*'    => 'nullable|string|min:1',
            'contact_person_ph_code'      => 'nullable|array|min:1',
            //'contact_person_ph_code.*'    => 'nullable|string|exists:countries,ph_code',
            'contact_person_phone'        => 'required|array|min:1',
            'contact_person_phone.*'      => ['required','string','distinct',$validate_cp_phone],
            'contact_person_whatsapp_code'      => 'nullable|array|min:1',
            //'contact_person_whatsapp_code.*'    => 'nullable|string|exists:countries,ph_code',
            'contact_person_whatsapp'     => 'nullable|array|min:1',
            'contact_person_whatsapp.*'   => ['nullable','string','distinct',$validate_cp_phone],
            'contact_person_comment'      => 'nullable|array|min:1',
            'contact_person_comment.*'    => 'nullable|string|distinct|min:1',
            
            'permanent_address'          => 'required|string|max:255',
            'permanent_addr_state_id'    => 'required|exists:states,id',
            'permanent_addr_city_id'     => 'nullable|exists:cities,id',
            'permanent_addr_postal_code' => 'required|digits:6',
            
            'present_address'            => 'required|string|max:255',
            'present_addr_state_id'      => 'required|exists:states,id',
            'present_addr_city_id'       => 'nullable|exists:cities,id',
            'present_addr_postal_code'   => 'required|digits:6',
            
            //------------------------------------------------------------------
            
            // 'coattachtypes'               => 'nullable|array|min:1',
            // 'coattachtypes.*'             => 'required|exists:coattachtypes,id',
            // 'coattachments'               => 'required|array|min:1',
            // 'coattachments.*'             => 'required|array|min:1',
            // 'coattachments.*.*'           => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
            
        ], [
                'required'             => 'This field is required.',
                'gstin.required_if'    => 'This field is required.',
                'contact_email.unique' => 'This email has already been taken.',
                'max'                  => 'Maximum 100 characters allowed.',
                'contact_comment.max'  => 'Maximum 255 characters allowed.',
                'exists'               => "This field's value is invalid.",
                'distinct'             => 'Duplicate value.',
                'email'                => 'This email is invalid.',
                // Custom field-specific messages:
                'phone.digits' => 'This field must contain 10 digits.',
                'whatsapp.digits' => 'This field must contain 10 digits.',
                'contact_person_phone.*.digits' => 'This field must contain 10 digits.',
                'contact_person_whatsapp.*.digits' => 'This field must contain 10 digits.',
            
                'contact_name.required' => 'This field is required.',
                'contact_name.max'      => 'This cannot exceed 100 characters.',
            ]
        );
        
        
        $validator->after(function ($validator) use ($request) {

            /*
            |--------------------------------------------------------------------------
            | Primary Bank Validation
            |--------------------------------------------------------------------------
            */
            $isPrimaryArr = $request->is_primary ?? [];
        
            $primaryCount = collect($isPrimaryArr)
                ->filter(fn($val) => $val === 'Yes')
                ->count();
        
            if ($primaryCount === 0) {
                $validator->errors()->add(
                    'is_primary',
                    'At least one bank must be marked as Primary.'
                );
            }
        
            if ($primaryCount > 1) {
                $validator->errors()->add(
                    'is_primary',
                    'Only one bank can be marked as Primary.'
                );
            }
            
            
        
        });
        
        
        
        $errorcount = 0;
        $errors = [];
        
        // For ADD NEW → no previous attachments
        $attachtype_ids = [];
        
        $attachtypes = $request->attachtypes ?? [];
        $filesInput  = $request->file('files') ?? [];
        
        $max = max(count($attachtypes), count($filesInput));
        
        for ($key = 0; $key < $max; $key++) {
        
            $attachtype = $attachtypes[$key] ?? null;
            $files      = $filesInput[$key] ?? null;
        
            // BOTH EMPTY → OK
            if (empty($attachtype) && empty($files)) {
                continue;
            }
        
            // FILE GIVEN BUT TYPE MISSING
            if (!empty($files) && empty($attachtype)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['Document type is required.'];
                continue;
            }
        
            // TYPE GIVEN BUT FILE MISSING
            if (!empty($attachtype) && empty($files)) {
                $errorcount++;
                $errors['coattachments_'.$key] = ['Please upload file.'];
                continue;
            }
        
            // DUPLICATE TYPE IN SAME REQUEST
            if (in_array($attachtype, $attachtype_ids)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['You’ve already added this attachment type.'];
                continue;
            }
        
            // Store type so next rows can't repeat
            $attachtype_ids[] = $attachtype;
        
            // FILE VALIDATION
            if (!empty($files)) {
        
                if (count($files) > 2) {
                    $errorcount++;
                    $errors['coattachments_'.$key] = ['You cannot upload more than 2 files.'];
                }
        
                foreach ($files as $file) {
        
                    $extension = strtolower($file->getClientOriginalExtension());
                    $size      = $file->getSize();
        
                    if (!in_array($extension, ['jpg','jpeg','png','pdf'])) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File type must be jpg, jpeg, png or pdf.'];
                    }
        
                    if ($size > 2097152) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File size must not exceed 2MB.'];
                    }
                }
            }
        }
        
        
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            \Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                //'input' => request()->all(), 
            ]);
            
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
        
        try {
            
            $contact = [];
            
            DB::transaction(function () use ($request, &$contact) {
                
                $lastcontact = Contact::withTrashed()->orderBy('id', 'DESC')->first();
                if($lastcontact){
                    $lastcontactno = $lastcontact->contactno;
                    $incr_lastcontact = $lastcontactno+1;
                    if(strlen($incr_lastcontact)<5){
                        $contactno = '0';
                        for($i = 0; $i<(5-strlen($incr_lastcontact)); $i++){
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
                //\Log::info('Current locale:', ['p' => $phoneCode]);
                
                
                $filename = null;
                if ($request->hasFile('contact_image')) {
                
                    $uploadPath = public_path('media' . DIRECTORY_SEPARATOR . 'contact');
                
                    // Create folder if not exists
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }
                
                    $file = $request->file('contact_image'); // single file
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'branch_' . time() . '_' . Str::random(6) . '.' . $extension;
                
                    // Move file
                    $file->move($uploadPath, $filename);
                }
                
                
            
                $contact  = new Contact;
                $contact->contactno       = $contactno;
                $contact->cotype_id       = self::CONTACT_TYPE_DRIVER;
                $contact->organisation_id = optional(Auth::user()?->organisation)->id;
                
                $contact->contact_name    = $request->contact_name;
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->phone;
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->whatsapp;
                $contact->contact_image   = $filename;
                $contact->contact_code    = $request->contact_code;
                $contact->dob             = $request->dob;
                $contact->blood_group     = $request->blood_group;
                $contact->religion_id     = $request->religion_id;
                $contact->doj             = $request->doj;
                $contact->status          = $request->status ?? 'Active';
                $contact->blacklist_reason = $request->blacklist_reason ?? null;
                $contact->rag_status       = $request->rag_status ?? null;
                $contact->comment          = $request->contact_comment ?? null;
                
                $contact->created_by         = Auth::user()->id;
                
                $contact->save();
                
                
                
                
                // Vehicle Allocation
                $vehicleAllocation  = new Vehicleallocation;
                $vehicleAllocation->contact_id  = $contact->id;
                $vehicleAllocation->type  = 'Driver';
                $vehicleAllocation->vehicle_id  = $request->vehicle_id;
                
                $vehicleAllocation->change_vehicle  = null;
                $vehicleAllocation->vehicle_change_reason  = null;
                $vehicleAllocation->km_allowed  = 0;
                $vehicleAllocation->fixed_amount  = 0;
                $vehicleAllocation->extra_amount_per_km  = 0;
                $vehicleAllocation->start_date  = null;
                $vehicleAllocation->end_date  = null;
                
                $vehicleAllocation->created_by  = Auth::user()->id;
                $vehicleAllocation->save();
                
                
                
                
                
                // Contact Persons + Users
                $names = $request->get('contact_person_name', []);
                for ($i = 0; $i < count($names); $i++) {
                    $name  = $names[$i] ?? null;
                    $relation = $request->get('contact_person_relation')[$i] ?? null;
                    $blood_group = $request->get('contact_person_blood_group')[$i] ?? null;
                    $address = $request->get('contact_person_address')[$i] ?? null;
                    
                    
                    $ph_code = $request->get('contact_person_ph_code')[$i] ?? null;
                    $phone = $request->get('contact_person_phone')[$i] ?? null;
                    
                    $whatsapp_code = $request->get('contact_person_whatsapp_code')[$i] ?? null;
                    $whatsapp = $request->get('contact_person_whatsapp')[$i] ?? null;
                    
                    $email = $request->get('contact_person_email')[$i] ?? null;
                    $comment = $request->get('contact_person_comment')[$i] ?? null;
                
                    // Skip if name, email, and phone all are empty
                    if (empty($name) && empty($phone)) {
                        continue;
                    }
                    
                    // Always create related contact if name or phone/email present
                    $relatedContact = new Relcontact;
                    $relatedContact->contact_id   = $contact->id;
                    $relatedContact->name         = $name;
                    $relatedContact->relationship = $relation;
                    $relatedContact->blood_group  = $blood_group;
                    $relatedContact->address      = $address;
                    
                    $relatedContact->ph_prefix        = $ph_code ?? $phoneCode;
                    $relatedContact->phone            = $phone;
                    $relatedContact->whatsapp_prefix  = $whatsapp_code ?? $phoneCode;
                    $relatedContact->whatsapp         = $whatsapp;
                    
                    $relatedContact->email      = $email;
                    $relatedContact->comment    = $comment;
                    $relatedContact->created_by = Auth::user()->id;
                    $relatedContact->save();
                }


            
                // Create Permanent Address 
                if (
                    !empty($request->get('permanent_address')) ||
                    !empty($request->get('permanent_addr_state_id')) ||
                    !empty($request->get('permanent_addr_postal_code'))
                ) {
                    $co_address = new Coaddress; 
                    $co_address->contact_id      = $contact->id;
                    $co_address->type            = 'Permanent';
                    $co_address->address         = $request->get('permanent_address');
                    $co_address->state_id        = $request->get('permanent_addr_state_id');
                    $co_address->city_id         = $request->get('permanent_addr_city_id');
                    $co_address->zipcode         = $request->get('permanent_addr_postal_code');
                    $co_address->additional_info = $request->get('permanent_addr_additional_info');
                    $co_address->save();
                }
                
                
                // Create Present Address 
                if (
                    !empty($request->get('present_address')) ||
                    !empty($request->get('present_addr_state_id')) ||
                    !empty($request->get('present_addr_postal_code'))
                ) {
                    $co_address = new Coaddress; 
                    $co_address->contact_id      = $contact->id;
                    $co_address->type            = 'Present';
                    $co_address->address         = $request->get('present_address');
                    $co_address->state_id        = $request->get('present_addr_state_id');
                    $co_address->city_id         = $request->get('present_addr_city_id');
                    $co_address->zipcode         = $request->get('present_addr_postal_code');
                    $co_address->additional_info = $request->get('present_addr_additional_info');
                    $co_address->save();
                }
                
                
                // Driver other infos
                if (!empty($request->get('driver_category')) ) {
                    
                    $licenseProofFileName = null;
                    if ($request->hasFile('driving_license_proof_file')) {
                        $uploadPath = public_path('media' . DIRECTORY_SEPARATOR . 'contact');
                        
                        // Create folder if not exists
                        if (!File::exists($uploadPath)) {
                            File::makeDirectory($uploadPath, 0755, true);
                        }
                        
                        $file = $request->file('driving_license_proof_file'); // single file
                        $extension = $file->getClientOriginalExtension();
                        $licenseProofFileName = 'driving_license_' . time() . '_' . Str::random(6) . '.' . $extension;
                    
                        // Move file
                        $file->move($uploadPath, $licenseProofFileName);
                    }
                    
                    $aadhaarCardProofFileName = null;
                    if ($request->hasFile('aadhaar_card_proof_file')) {
                        $uploadPath = public_path('media' . DIRECTORY_SEPARATOR . 'contact');
                        
                        // Create folder if not exists
                        if (!File::exists($uploadPath)) {
                            File::makeDirectory($uploadPath, 0755, true);
                        }
                        
                        $file = $request->file('aadhaar_card_proof_file'); // single file
                        $extension = $file->getClientOriginalExtension();
                        $aadhaarCardProofFileName = 'aadhaar_card_' . time() . '_' . Str::random(6) . '.' . $extension;
                    
                        // Move file
                        $file->move($uploadPath, $aadhaarCardProofFileName);
                    }
                    
                    $signedDriverFormFileName = null;
                    if ($request->hasFile('signed_driver_form_file')) {
                        $uploadPath = public_path('media' . DIRECTORY_SEPARATOR . 'contact');
                        
                        // Create folder if not exists
                        if (!File::exists($uploadPath)) {
                            File::makeDirectory($uploadPath, 0755, true);
                        }
                        
                        $file = $request->file('signed_driver_form_file'); // single file
                        $extension = $file->getClientOriginalExtension();
                        $signedDriverFormFileName = 'signed_driver_form_' . time() . '_' . Str::random(6) . '.' . $extension;
                    
                        // Move file
                        $file->move($uploadPath, $signedDriverFormFileName);
                    }
                    
                    
                    $contact_other_info = new Driverinfo; 
                    $contact_other_info->contact_id        = $contact->id;
                    $contact_other_info->category          = $request->driver_category ?? null;
                    $contact_other_info->driving_licence_no= $request->driving_licence_no ?? null;
                    $contact_other_info->licence_issue_date= $request->licence_issue_date ?? null;
                    $contact_other_info->licence_expiry_date = $request->licence_expiry_date ?? null;
                    $contact_other_info->original_licence_location  = $request->original_licence_location ?? null;
                    $contact_other_info->driving_license_proof_file = $licenseProofFileName ?? null;
                    $contact_other_info->aadhaar_no                 = $request->aadhaar_no ?? null;
                    $contact_other_info->aadhaar_card_proof_file    = $aadhaarCardProofFileName ?? null;
                    $contact_other_info->signed_driver_form_file    = $signedDriverFormFileName ?? null;
                    
                    $contact_other_info->status_type          = $request->status_type ?? null;
                    $contact_other_info->expected_return_date = $request->expected_return_date ?? null;
                    $contact_other_info->set_reminder         = $request->set_reminder ?? null;
                    $contact_other_info->voluntary_exit_reason= $request->voluntary_exit_reason ?? null;
                    $contact_other_info->hisab_category       = $request->hisab_category ?? null;
                    $contact_other_info->opening_balance_date = $request->opening_balance_date ?? null;
                    $contact_other_info->opening_balance_type = $request->opening_balance_type ?? null;
                    $contact_other_info->opening_balance      = $request->opening_balance ?? null;
                    $contact_other_info->guarantor_name       = $request->guarantor_name ?? null;
                    $contact_other_info->guarantor_phone_code = $request->guarantor_phone_code ?? $phoneCode;
                    $contact_other_info->guarantor_phone      = $request->guarantor_phone ?? null;
                    
                    $contact_other_info->save();
                }
                
                
                // Driver vehicle photos
                if ($request->hasFile('vehicle_photos')) {

                    foreach ($request->file('vehicle_photos') as $photo) {
                        
                        $uploadPath = public_path('media' . DIRECTORY_SEPARATOR . 'contact');
                        // Create folder if not exists
                        if (!File::exists($uploadPath)) {
                            File::makeDirectory($uploadPath, 0755, true);
                        }
                        
                        $extension = $photo->getClientOriginalExtension();
                        $filename = 'vehicle_photo_' . time() . '_' . Str::random(6) . '.' . $extension;
                    
                        // Move file
                        $file->move($uploadPath, $filename);
                
                        // Save 
                        $vehiclephoto  = new Drivervehiclephoto;
                        $vehiclephoto->contact_id = $contact->id;
                        $vehiclephoto->file_name  = $filename;
                        $vehiclephoto->save();
                    }
                }
                
                
                // Contactbank
                /*if (
                    !empty($request->get('bank_id')) 
                ) {
                    $contact_bank = new Contactbank; 
                    $contact_bank->contact_id        = $contact->id;
                    $contact_bank->bank_id           = $request->bank_id;
                    $contact_bank->account_number    = $request->account_number;
                    $contact_bank->beneficiary_name  = $request->beneficiary_name;
                    $contact_bank->ifsc_code         = $request->ifsc_code;
                    $contact_bank->upi_id            = $request->upi_id;
                    $contact_bank->save();
                }*/
                
                $isPrimaryArr = $request->is_primary;
                $bankIds = $request->bank_id;
                $beneficiaryNames = $request->beneficiary_name ?? [];
                $accountNumbers = $request->account_number;
                $ifscCodes = $request->ifsc_code;
                $upiIds = $request->upi_id ?? [];
                
                for ($i = 0; $i < count($bankIds); $i++) {

                    if ($isPrimaryArr[$i] === 'Yes') {
                        // Make sure no previous bank is primary
                        Contactbank::where('contact_id', $contact->id)->update(['is_primary' => 'No']);
                    }
                
                    $bank = new Contactbank();
                    $bank->contact_id = $contact->id;
                    $bank->bank_id = $bankIds[$i];
                    $bank->is_primary = $isPrimaryArr[$i] === 'Yes' ? 'Yes' : 'No';
                    $bank->beneficiary_name = $beneficiaryNames[$i] ?? null;
                    $bank->account_number = $accountNumbers[$i];
                    $bank->ifsc_code = $ifscCodes[$i];
                    $bank->upi_id = $upiIds[$i] ?? null;
                    $bank->save();
                }
                
                
                
                
                $attachtypes = $request->attachtypes;
                if(!empty($attachtypes)){
                    foreach($attachtypes as $key => $attachtype){
                        if(isset($request->file('files')[$key])){
                            $files = $request->file('files')[$key];
                            
                            foreach($files as $file){
                                $fileoriginalname = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();
                                $filesize = $file->getSize();

                                // Keep original extension
                                $filename = 'contact-attachment-'.Str::random(4).'_'.time().'.'.$extension;

                                $file->move(
                                    public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR),
                                    $filename
                                );
                                
                               
                                $contact_attachment = new Coattachment;
                                $contact_attachment->name              = $filename;
                                $contact_attachment->original_name     = $fileoriginalname;
                                $contact_attachment->file_size         = ($filesize/(1024 *1024));
                                $contact_attachment->coattachtype_id   = $attachtype;
                                $contact_attachment->created_by        = Auth::id();
                                $contact_attachment->contact_id        = $contact->id;
                                $contact_attachment->save();
                            }
                        }
                    } 
                }
                
                
                // Log activity
                $description = 'Added new driver contact with ID ' . $contact->id;
                $this->storeUseractivity(3, 3, Auth::user()->id, $contact->id, $description);

            });
        
        
            return response()->json([
                'success' => true,
                'data'    => $contact,
                'message' => 'Driver saved successfully.'
            ]);
            
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage()
            ]);
        }
    }
    
    
    
    public function editDriver(Request $request, $id) 
    {
        
         $contact = Contact::with([
             'relcontacts',
             'coaddresses',
             'bank',
             'driverinfo',
             'vehicleAllocations',
             'employeeAssets',
             'coattachments.coattachtype',
             'activities',
             'activities.createdBy',
         ])
         ->where('cotype_id',self::CONTACT_TYPE_DRIVER)
         ->where('id',$id)
         ->first();
         
        //dd($contact->employeeAssets);
        //dd($contact->vehicleAllocations);
        
        
        $countries = Country::all();
        
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
                        
        $cotypes   = Cotype::all();
        $customerabouttype = Customerabouttype::orderBy('name')->get();
        $religions = Religion::orderBy('name')->get();
        
        $banks = Bank::orderBy('name')->get();
        $vehicles = Vehicle::where('status', 'Active')->get(); 
        
        $gsttreats = Gsttreat::all();   
        $coattachtypes = Coattachtype::whereNotIn('name', ['Driving License', 'Aadhaar Card'])->get();
        $cotype        = $cotypes->firstWhere('id', self::CONTACT_TYPE_DRIVER);
        
        
        // split addresses by type
        $permanentAddress = $contact->coaddresses->firstWhere('type', 'Permanent');
        $presentAddress   = $contact->coaddresses->firstWhere('type', 'Present');
        
        
        $totalMonths = 0;
        if ($contact->workExperiences && $contact->workExperiences->isNotEmpty()) {
            foreach ($contact->workExperiences as $exp) {
                if ($exp->employment_start_date && $exp->employment_end_date) {
                    $start = Carbon::parse($exp->employment_start_date);
                    $end   = Carbon::parse($exp->employment_end_date);
            
                    // Only add if end >= start
                    if ($end >= $start) {
                        $diffMonths = $start->diffInMonths($end);
                        $totalMonths += $diffMonths;
                    }
                }
            }
        }
        
        // Safe conversion to years and months
        $totalYears = $totalMonths > 0 ? floor($totalMonths / 12) : 0;
        $remainingMonths = $totalMonths > 0 ? $totalMonths % 12 : 0;
        
         
         //dd($contact);
         
         // Log activity
         $description = 'Retrieve a driver named '.$contact->contact_name.' to edit.';
         $useractivity = $this->storeUseractivity(3, 5, Auth::user()->id, $contact->id, $description);
         
         return view('contacts.driver.edit', compact(
                                                    'contact',
                                                    'customerabouttype',
                                                    'countries',
                                                    'states',
                                                    'cotype',
                                                    'cotypes',
                                                    'gsttreats',
                                                    'coattachtypes',
                                                    'religions',
                                                    'cities',
                                                    'banks',
                                                    'vehicles',
                                                    'permanentAddress',
                                                    'presentAddress',
                                                    'totalYears',
                                                    'remainingMonths'
                                                ));
                                                
    }
    
    
    public function updateDriver(Request $request, $id)
    {
        $request->merge([
            'phone'    => preg_replace('/\s+/', '', $request->phone),
            'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp),
            'guarantor_phone' => preg_replace('/\s+/', '', $request->guarantor_phone),
            'change_vehicle' => $request->change_vehicle ? 'Yes' : 'No',
            'set_reminder' => $request->set_reminder ? 'Yes' : 'No',
        ]);

        $validate_phone = function ($attribute, $value, $fail) use ($request, $id) {
            // phone_code optional — check uniqueness without prefix if absent
            $code  = $request->phone_code;
            $query = Contact::where('phone', $value)->where('id', '!=', $id);
            if ($code) {
                $query->where('ph_prefix', $code);
            }
            if ($query->exists()) {
                $fail('This phone number already exists.');
            }
        };

        $validate_whatsapp = function ($attribute, $value, $fail) use ($request) {
            if (!$value) return; // whatsapp optional — no code check
        };

        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) use ($request) {
            // contact_person_phone optional — skip if value empty
            if (!$value) return;
        };
        
        // if (User::where('email', $request->email)->exists()) {
        //     $fail('This email id already exists.');
        // }
        
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_DRIVER)->find($id);
    
        if (!$contact) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Driver not found.'
            ], 422);
        }
        
        
        $validator = Validator::make($request->all(), [
            //'licence_no'          => 'nullable',
            'contact_name'        => 'required|max:100',
            'contact_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'contact_code'        => 'required|max:100',
            'driver_category'     => 'required|in:Local,Line',
            
            'change_vehicle'        => 'required|in:Yes,No',
            
            'vehicle_id'            => [

                                            Rule::requiredIf(function () use ($request) {
                                                return $request->change_vehicle == 'Yes';
                                            }),
                                        
                                            'nullable',
                                            'exists:vehicles,id',
                                        
                                            function ($attribute, $value, $fail) use ($request) {
                                        
                                                if ($request->change_vehicle == 'Yes' && $value) {
                                                    
                                                    $exists = Vehicleallocation::where('vehicle_id', $value)->where('type', 'Driver')->exists();
                                                    if ($exists) {
                                                        $fail('This vehicle is already allocated to a driver.');
                                                    }
                                        
                                                }
                                        
                                            }
                                        
                                        ],
                                        
            'vehicle_change_reason' => [
                                        'nullable',
                                        'string',
                                        'max:255',
                                        Rule::requiredIf(function () use ($request) {
                                            return $request->change_vehicle == 'Yes';
                                        }),
                                    ],
            
            
            //'phone_code'        => 'nullable|exists:countries,ph_code',
            'phone'               => [
                                        'required',
                                        'digits:10',
                                        Rule::unique('contacts','phone')->ignore($contact->id)
                                    ],
            //'whatsapp_code'     => 'nullable|exists:countries,ph_code',
            'whatsapp'            => 'nullable|digits:10',
            
            'dob'                 => 'nullable|date_format:Y-m-d',
            'doj'                 => 'required|date|before_or_equal:today',
            'blood_group'         => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'religion_id'         => 'nullable|exists:religions,id',

            'driving_licence_no'  => 'required|string|max:255',
            'licence_issue_date'  => 'required|date_format:Y-m-d',
            'licence_expiry_date' => 'required|date_format:Y-m-d',
            'original_licence_location' => 'required|string|max:255',
            'driving_license_proof_file' => 'nullable|file|max:2048',

            'aadhaar_no' => 'required|string|max:255',
            'aadhaar_card_proof_file' => 'nullable|file|max:2048',
            'signed_driver_form_file' => 'nullable|file|max:2048',
            
            'status'              => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'    => 'required_if:status,Blacklisted',
            'status_type'         => 'nullable|required_if:status,Inactive|in:On Leave,Voluntary Exit',
            'expected_return_date'=> 'nullable|date|date_format:Y-m-d|required_if:status_type,On Leave|required_if:status,Inactive',
            'set_reminder'        => [
                                    'nullable',
                                    'in:Yes,No',
                                    Rule::requiredIf(function () use ($request) {
                                        return $request->status == 'Inactive' && $request->status_type == 'On Leave';
                                    }),
                                ],

            'rag_status'          => 'nullable|in:Red,Yellow,Green',
            
            'voluntary_exit_reason' => [
                                        'nullable',
                                        Rule::requiredIf(function () use ($request) {
                                            return $request->status == 'Inactive' && $request->status_type == 'Voluntary Exit';
                                        }),
                                    ],
                                    
            'vehicle_photos'    => [
                                    'nullable',
                                    'array',
                                    Rule::requiredIf(function () use ($request) {
                                        return $request->status == 'Inactive' && $request->status_type == 'Voluntary Exit';
                                    }),
                                ],

            'vehicle_photos.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            
            
            'hisab_category'       => 'nullable|in:Fixed,Fuel',
            'opening_balance_date' => 'nullable|date|date_format:Y-m-d',
            'opening_balance_type' => 'nullable|in:Credit,Debit',
            'opening_balance'      => 'nullable|numeric|min:0',
            'guarantor_name'    => 'nullable|string|max:255',
            'guarantor_phone'   => 'nullable|digits:10',
            'contact_comment'   => 'nullable|string|max:255',

            'is_primary' => 'nullable|array',
            'is_primary.*' => 'nullable|in:Yes,No',

            'bank_id' => 'nullable|array',
            'bank_id.*' => 'nullable|exists:banks,id',

            'beneficiary_name' => 'nullable|array',
            'beneficiary_name.*' => 'nullable|string|max:255',

            'account_number' => 'nullable|array',
            'account_number.*' => 'nullable|string|max:50',

            'ifsc_code' => 'nullable|array',
            'ifsc_code.*' => 'nullable|string|max:20',

            'upi_id' => 'nullable|array',
            'upi_id.*' => 'nullable|string|max:100',

            'contact_person_name'         => 'nullable|array',
            'contact_person_name.*'       => 'nullable|string|distinct',
            'contact_person_relation'     => 'nullable|array',
            'contact_person_relation.*'   => 'nullable|string',
            'contact_person_blood_group'  => 'nullable|array',
            'contact_person_blood_group.*'=> 'nullable|string',
            'contact_person_address'      => 'nullable|array',
            'contact_person_address.*'    => 'nullable|string',
            'contact_person_ph_code'      => 'nullable|array',
            'contact_person_phone'        => 'nullable|array',
            'contact_person_phone.*'      => 'nullable|string|distinct',
            'contact_person_whatsapp_code'=> 'nullable|array',
            'contact_person_whatsapp'     => 'nullable|array',
            'contact_person_whatsapp.*'   => 'nullable|string|distinct',
            'contact_person_comment'      => 'nullable|array',
            'contact_person_comment.*'    => 'nullable|string',

            'permanent_address'          => 'nullable|string|max:255',
            'permanent_addr_state_id'    => 'nullable|exists:states,id',
            'permanent_addr_city_id'     => 'nullable|exists:cities,id',
            'permanent_addr_postal_code' => 'nullable|digits:6',

            'present_address'            => 'nullable|string|max:255',
            'present_addr_state_id'      => 'nullable|exists:states,id',
            'present_addr_city_id'       => 'nullable|exists:cities,id',
            'present_addr_postal_code'   => 'nullable|digits:6',
            
            //------------------------------------------------------------------
            
            // 'coattachtypes'               => 'nullable|array|min:1',
            // 'coattachtypes.*'             => 'required|exists:coattachtypes,id',
            // 'coattachments'               => 'required|array|min:1',
            // 'coattachments.*'             => 'required|array|min:1',
            // 'coattachments.*.*'           => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
            
        ], [
                'required'             => 'This field is required.',
                'gstin.required_if'    => 'This field is required.',
                'contact_email.unique' => 'This email has already been taken.',
                'max'                  => 'Maximum 100 characters allowed.',
                'contact_comment.max'  => 'Maximum 255 characters allowed.',
                'exists'               => "This field's value is invalid.",
                'distinct'             => 'Duplicate value.',
                'email'                => 'This email is invalid.',
                // Custom field-specific messages:
                'phone.digits' => 'This field must contain 10 digits.',
                'whatsapp.digits' => 'This field must contain 10 digits.',
                'contact_person_phone.*.digits' => 'This field must contain 10 digits.',
                'contact_person_whatsapp.*.digits' => 'This field must contain 10 digits.',
            
                'contact_name.required' => 'This field is required.',
                'contact_name.max'      => 'This cannot exceed 100 characters.',
            ]
        );
        
        
        $validator->after(function ($validator) use ($request, $contact) {

            /*
            |--------------------------------------------------------------------------
            | Primary Bank Validation
            |--------------------------------------------------------------------------
            */
        
            $primaryCount = collect($request->is_primary ?? [])
                ->filter(fn($val) => $val === 'Yes')
                ->count();
        
            if ($primaryCount === 0) {
                $validator->errors()->add(
                    'is_primary.0',
                    'At least one bank must be marked as Primary.'
                );
            }
        
            if ($primaryCount > 1) {
                $validator->errors()->add(
                    'is_primary.0',
                    'Only one bank can be marked as Primary.'
                );
            }
        
        });
        
        
    
        $errorcount = 0;
        $errors = [];
        
        // Safe initialization (works even if no attachments exist)
        $attachtype_ids = [];
        if(isset($contact)){
            $attachtype_ids = $contact->coattachments->pluck('coattachtype_id')->toArray();
        }
        
        $attachtypes = $request->attachtypes ?? [];
        $filesInput  = $request->file('files') ?? [];
        
        $max = max(count($attachtypes), count($filesInput));
        
        for ($key = 0; $key < $max; $key++) {
        
            $attachtype = $attachtypes[$key] ?? null;
            $files      = $filesInput[$key] ?? null;
        
            // BOTH EMPTY → OK
            if (empty($attachtype) && empty($files)) {
                continue;
            }
        
            // FILE GIVEN BUT TYPE MISSING
            if (!empty($files) && empty($attachtype)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['Document type is required.'];
                continue;
            }
        
            // TYPE GIVEN BUT FILE MISSING
            if (!empty($attachtype) && empty($files)) {
                $errorcount++;
                $errors['coattachments_'.$key] = ['Please upload file.'];
                continue;
            }
        
            // DUPLICATE TYPE CHECK (only if any exist)
            if (!empty($attachtype_ids) && in_array($attachtype, $attachtype_ids)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['You’ve already added this attachment type.'];
                continue;
            }
        
            // Add to array so same request can't repeat type
            $attachtype_ids[] = $attachtype;
        
            // FILE VALIDATION
            if (!empty($files)) {
        
                if (count($files) > 2) {
                    $errorcount++;
                    $errors['coattachments_'.$key] = ['You cannot upload more than 2 files.'];
                }
        
                foreach ($files as $file) {
        
                    $extension = strtolower($file->getClientOriginalExtension());
                    $size      = $file->getSize();
        
                    if (!in_array($extension, ['jpg','jpeg','png','pdf'])) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File type must be jpg, jpeg, png or pdf.'];
                    }
        
                    if ($size > 2097152) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File size must not exceed 2MB.'];
                    }
                }
            }
        }
        
        
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            \Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                //'input' => request()->all(), 
            ]);
            
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
        
    
        try {
            
            
            DB::transaction(function () use ($request, $contact) {
                
                $phoneCode = getPhoneCode();
                //\Log::info('Current locale:', ['p' => $phoneCode]);
                
                $filename = $contact->contact_image;
                if ($request->hasFile('contact_image')) {

                    $uploadPath = public_path('media/contact');
    
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath,0755,true);
                    }
    
                    $file = $request->file('contact_image');
                    $filename = 'contact_'.time().'_'.Str::random(6).'.'.$file->getClientOriginalExtension();
    
                    $file->move($uploadPath,$filename);
    
                    $contact->contact_image = $filename;
                }
                
                
                $contact->contact_name = $request->contact_name;
                $contact->ph_prefix = $request->phone_code ?? $phoneCode;
                $contact->phone = $request->phone;
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp = $request->whatsapp;
                $contact->contact_code = $request->contact_code;
                $contact->dob = $request->dob;
                $contact->blood_group = $request->blood_group;
                $contact->religion_id = $request->religion_id;
                $contact->doj = $request->doj;
                $contact->status = $request->status ?? 'Active';
                $contact->blacklist_reason = $request->get('blacklist_reason') ?? null;
                $contact->rag_status = $request->rag_status;
                $contact->contact_image   = $filename;
                $contact->comment = $request->contact_comment;
                
                $contact->updated_by      = Auth::user()->id;
                $contact->save();
                
                
                /*
                |--------------------------------------------------------------------------
                | Vehicle Allocation Update
                |--------------------------------------------------------------------------
                */
                if ($request->change_vehicle == 'Yes') {

                    // Remove old vehicle
                    Vehicleallocation::where('contact_id', $contact->id)->delete();
                
                    // Add new vehicle
                    $vehicleAllocation  = new Vehicleallocation;
                    $vehicleAllocation->contact_id  = $contact->id;
                    $vehicleAllocation->type  = 'Driver';
                    $vehicleAllocation->vehicle_id  = $request->vehicle_id;
                    $vehicleAllocation->change_vehicle  = $request->change_vehicle ?? 'No';
                    $vehicleAllocation->vehicle_change_reason = $request->vehicle_change_reason ?? null;
                    
                    $vehicleAllocation->km_allowed  = 0;
                    $vehicleAllocation->fixed_amount  = 0;
                    $vehicleAllocation->extra_amount_per_km  = 0;
                    $vehicleAllocation->start_date  = null;
                    $vehicleAllocation->end_date  = null;
                
                    $vehicleAllocation->created_by  = Auth::user()->id;
                    $vehicleAllocation->save();
                }


                
                
                // Driver other infos
                if (!empty($request->get('driver_category'))) {
                
                    $contact_other_info = Driverinfo::where('contact_id', $contact->id)->first();
                
                    if (!$contact_other_info) {
                        $contact_other_info = new Driverinfo;
                        $contact_other_info->contact_id = $contact->id;
                    }
                
                    $uploadPath = public_path('media' . DIRECTORY_SEPARATOR . 'contact');
                
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }
                
                    // Driving License File
                    if ($request->hasFile('driving_license_proof_file')) {
                
                        if (!empty($contact_other_info->driving_license_proof_file) &&
                            File::exists($uploadPath . DIRECTORY_SEPARATOR . $contact_other_info->driving_license_proof_file)) {
                
                            File::delete($uploadPath . DIRECTORY_SEPARATOR . $contact_other_info->driving_license_proof_file);
                        }
                
                        $file = $request->file('driving_license_proof_file');
                        $extension = $file->getClientOriginalExtension();
                        $filename = 'driving_license_' . time() . '_' . Str::random(6) . '.' . $extension;
                
                        $file->move($uploadPath, $filename);
                
                        $contact_other_info->driving_license_proof_file = $filename;
                    }
                
                    // Aadhaar Card File
                    if ($request->hasFile('aadhaar_card_proof_file')) {
                
                        if (!empty($contact_other_info->aadhaar_card_proof_file) &&
                            File::exists($uploadPath . DIRECTORY_SEPARATOR . $contact_other_info->aadhaar_card_proof_file)) {
                
                            File::delete($uploadPath . DIRECTORY_SEPARATOR . $contact_other_info->aadhaar_card_proof_file);
                        }
                
                        $file = $request->file('aadhaar_card_proof_file');
                        $extension = $file->getClientOriginalExtension();
                        $filename = 'aadhaar_card_' . time() . '_' . Str::random(6) . '.' . $extension;
                
                        $file->move($uploadPath, $filename);
                
                        $contact_other_info->aadhaar_card_proof_file = $filename;
                    }
                
                    // Signed Driver Form File
                    if ($request->hasFile('signed_driver_form_file')) {
                
                        if (!empty($contact_other_info->signed_driver_form_file) &&
                            File::exists($uploadPath . DIRECTORY_SEPARATOR . $contact_other_info->signed_driver_form_file)) {
                
                            File::delete($uploadPath . DIRECTORY_SEPARATOR . $contact_other_info->signed_driver_form_file);
                        }
                
                        $file = $request->file('signed_driver_form_file');
                        $extension = $file->getClientOriginalExtension();
                        $filename = 'signed_driver_form_' . time() . '_' . Str::random(6) . '.' . $extension;
                
                        $file->move($uploadPath, $filename);
                
                        $contact_other_info->signed_driver_form_file = $filename;
                    }
                
                    // Update fields
                    $contact_other_info->category                   = $request->driver_category ?? null;
                    $contact_other_info->driving_licence_no         = $request->driving_licence_no ?? null;
                    $contact_other_info->licence_issue_date         = $request->licence_issue_date ?? null;
                    $contact_other_info->licence_expiry_date        = $request->licence_expiry_date ?? null;
                    $contact_other_info->original_licence_location  = $request->original_licence_location ?? null;
                
                    $contact_other_info->aadhaar_no                 = $request->aadhaar_no ?? null;
                
                    $contact_other_info->status_type                = $request->status_type ?? null;
                    $contact_other_info->expected_return_date       = $request->expected_return_date ?? null;
                    $contact_other_info->set_reminder               = $request->set_reminder ?? null;
                    $contact_other_info->voluntary_exit_reason      = $request->voluntary_exit_reason ?? null;
                
                    $contact_other_info->hisab_category             = $request->hisab_category ?? null;
                    $contact_other_info->opening_balance_date       = $request->opening_balance_date ?? null;
                    $contact_other_info->opening_balance_type       = $request->opening_balance_type ?? null;
                    $contact_other_info->opening_balance            = $request->opening_balance ?? null;
                
                    $contact_other_info->guarantor_name             = $request->guarantor_name ?? null;
                    $contact_other_info->guarantor_phone_code       = $request->guarantor_phone_code ?? $phoneCode;
                    $contact_other_info->guarantor_phone            = $request->guarantor_phone ?? null;
                
                    $contact_other_info->save();
                }
                
                
                
                // Vehicle Photos
                if ($request->hasFile('vehicle_photos')) {

                    foreach ($request->file('vehicle_photos') as $photo) {
                        
                        $uploadPath = public_path('media' . DIRECTORY_SEPARATOR . 'contact');
                        // Create folder if not exists
                        if (!File::exists($uploadPath)) {
                            File::makeDirectory($uploadPath, 0755, true);
                        }
                        
                        $extension = $photo->getClientOriginalExtension();
                        $filename = 'vehicle_photo_' . time() . '_' . Str::random(6) . '.' . $extension;
                    
                        // Move file
                        $file->move($uploadPath, $filename);
                
                        // Save 
                        $vehiclephoto  = new Drivervehiclephoto;
                        $vehiclephoto->contact_id = $contact->id;
                        $vehiclephoto->file_name  = $filename;
                        $vehiclephoto->save();
                    }
                }
                
                
                
                // === Update Relcontacts ===
                Relcontact::where('contact_id',$contact->id)->delete();
                $names = $request->get('contact_person_name', []);
                for ($i = 0; $i < count($names); $i++) {
                    $name  = $names[$i] ?? null;
                    $relation = $request->get('contact_person_relation')[$i] ?? null;
                    $blood_group = $request->get('contact_person_blood_group')[$i] ?? null;
                    $address = $request->get('contact_person_address')[$i] ?? null;
                    
                    
                    $ph_code = $request->get('contact_person_ph_code')[$i] ?? null;
                    $phone = $request->get('contact_person_phone')[$i] ?? null;
                    
                    $whatsapp_code = $request->get('contact_person_whatsapp_code')[$i] ?? null;
                    $whatsapp = $request->get('contact_person_whatsapp')[$i] ?? null;
                    
                    $email = $request->get('contact_person_email')[$i] ?? null;
                    $comment = $request->get('contact_person_comment')[$i] ?? null;
                
                    // Skip if name, email, and phone all are empty
                    if (empty($name) && empty($phone)) {
                        continue;
                    }
                    
                    // Always create related contact if name or phone/email present
                    $relatedContact = new Relcontact;
                    $relatedContact->contact_id   = $contact->id;
                    $relatedContact->name         = $name;
                    $relatedContact->relationship = $relation;
                    $relatedContact->blood_group  = $blood_group;
                    $relatedContact->address      = $address;
                    
                    $relatedContact->ph_prefix        = $ph_code ?? $phoneCode;
                    $relatedContact->phone            = $phone;
                    $relatedContact->whatsapp_prefix  = $whatsapp_code ?? $phoneCode;
                    $relatedContact->whatsapp         = $whatsapp;
                    
                    $relatedContact->email      = $email;
                    $relatedContact->comment    = $comment;
                    $relatedContact->created_by = Auth::user()->id;
                    $relatedContact->save();
                }
                
                
                // Permanent Address
                if (
                    !empty($request->get('permanent_address')) ||
                    !empty($request->get('permanent_addr_state_id')) ||
                    !empty($request->get('permanent_addr_postal_code'))
                ) {
                
                    $co_address = Coaddress::where('contact_id', $contact->id)
                                    ->where('type', 'Permanent')
                                    ->first();
                
                    if (!$co_address) {
                        $co_address = new Coaddress;
                        $co_address->contact_id = $contact->id;
                        $co_address->type = 'Permanent';
                    }
                
                    $co_address->address         = $request->get('permanent_address');
                    $co_address->state_id        = $request->get('permanent_addr_state_id');
                    $co_address->city_id         = $request->get('permanent_addr_city_id');
                    $co_address->zipcode         = $request->get('permanent_addr_postal_code');
                    $co_address->additional_info = $request->get('permanent_addr_additional_info');
                    $co_address->save();
                }
                
                
                // Present Address
                if (
                    !empty($request->get('present_address')) ||
                    !empty($request->get('present_addr_state_id')) ||
                    !empty($request->get('present_addr_postal_code'))
                ) {
                
                    $co_address = Coaddress::where('contact_id', $contact->id)
                                    ->where('type', 'Present')
                                    ->first();
                
                    if (!$co_address) {
                        $co_address = new Coaddress;
                        $co_address->contact_id = $contact->id;
                        $co_address->type = 'Present';
                    }
                
                    $co_address->address         = $request->get('present_address');
                    $co_address->state_id        = $request->get('present_addr_state_id');
                    $co_address->city_id         = $request->get('present_addr_city_id');
                    $co_address->zipcode         = $request->get('present_addr_postal_code');
                    $co_address->additional_info = $request->get('present_addr_additional_info');
                    $co_address->save();
                }
                
                
                
                
                // === Update Bank Details ===

                $bankDetailIds = [];
                
                $bankIds          = $request->bank_id ?? [];
                $isPrimaryArr     = $request->is_primary ?? [];
                $beneficiaryNames = $request->beneficiary_name ?? [];
                $accountNumbers   = $request->account_number ?? [];
                $ifscCodes        = $request->ifsc_code ?? [];
                $upiIds           = $request->upi_id ?? [];
                $contactBankIds   = $request->contact_bank_id ?? []; // hidden input for existing bank row id
                
                foreach ($bankIds as $i => $bankId) {
                
                    // Find existing or create new
                    $bank = Contactbank::find($contactBankIds[$i] ?? 0);
                
                    if (!$bank) {
                        $bank = new Contactbank();
                        $bank->contact_id = $contact->id;
                    }
                
                    // If this one is primary → make others No
                    if (($isPrimaryArr[$i] ?? 'No') === 'Yes') {
                        Contactbank::where('contact_id', $contact->id)->update(['is_primary' => 'No']);
                    }
                
                    $bank->bank_id          = $bankId;
                    $bank->is_primary       = ($isPrimaryArr[$i] ?? 'No') === 'Yes' ? 'Yes' : 'No';
                    $bank->beneficiary_name = $beneficiaryNames[$i] ?? null;
                    $bank->account_number   = $accountNumbers[$i] ?? null;
                    $bank->ifsc_code        = $ifscCodes[$i] ?? null;
                    $bank->upi_id           = $upiIds[$i] ?? null;
                    $bank->save();
                
                    $bankDetailIds[] = $bank->id;
                }
                
                // Delete removed bank records
                Contactbank::where('contact_id', $contact->id)
                    ->whereNotIn('id', $bankDetailIds)
                    ->delete();
                
                
                
                
                
    
                
                // === TODO: Handle Attachments (if needed) ===
                $attachtypes = $request->attachtypes;
                if(!empty($attachtypes)){
            
                    foreach($attachtypes as $key => $attachtype){
                        
                        if(isset($request->file('files')[$key])){
                            $files = $request->file('files')[$key];
                            
                            foreach($files as $file){
                                $fileoriginalname = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();
                                $filesize = $file->getSize();

                                // Keep original extension
                                $filename = 'contact-attachment-'.Str::random(4).'_'.time().'.'.$extension;

                                $file->move(
                                    public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR),
                                    $filename
                                );
                                
                                
                                $contact_attachment = new Coattachment;
                                $contact_attachment->name              = $filename;
                                $contact_attachment->original_name     = $fileoriginalname;
                                $contact_attachment->file_size         = ($filesize/(1024 *1024));
                                $contact_attachment->coattachtype_id   = $attachtype;
                                $contact_attachment->created_by        = Auth::id();
                                $contact_attachment->contact_id        = $contact->id;
                                $contact_attachment->save();
                            }
                            
                        }
                    } 
                }
                
                
                // Log activity
                $this->storeUseractivity(3, 4, Auth::user()->id, $contact->id, 'Driver Updated [ID: ' . $contact->id . '].');
                
            });
    
            return response()->json([
                'success' => true,
                'data'    => $contact,
                'message' => 'Driver updated successfully.'
            ]);
        } catch (\Exception $exp) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage()
            ]);
        }
    }
    
    
    public function storeDriverWorkExperience(Request $request)
    {
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_DRIVER)->find($request->contact_id); 

        if (!$contact) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Employee not found!'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'contact_id'                      => 'required|exists:contacts,id',
            'previous_company_name'           => 'required|max:255',
            'previous_designation'            => 'required|max:255', 
            'previous_employment_duration' => ['required', function ($attribute, $value, $fail) use ($request) {
                // Split input
                $dates = explode(' - ', $value);
            
                if (count($dates) !== 2) {
                    $fail('The employment duration format is invalid.');
                    return;
                }
            
                try {
                    $start = Carbon::parse(trim($dates[0]))->format('Y-m-d');
                    $end   = Carbon::parse(trim($dates[1]))->format('Y-m-d');
                } catch (\Exception $e) {
                    $fail('The employment duration contains invalid dates.');
                    return;
                }
            
                if ($end > date('Y-m-d')) {
                    $fail('The end date cannot be a future date.');
                }
            
                if ($start > $end) {
                    $fail('The start date cannot be after the end date.');
                }
            
                // Check for overlapping date ranges (new_start <= existing_end AND new_end >= existing_start)
                $exists = Employeeworkexperience::where('contact_id', $request->contact_id)
                                                ->where('employment_start_date', '<=', $end)
                                                ->where('employment_end_date', '>=', $start)
                                                ->exists();
            
                if ($exists) {
                    $fail('This employment period overlaps with an existing experience.');
                }
            }],
            'previous_exit_reason'            => 'required|max:500',
            'previous_salary'                 => 'required|numeric|min:1',
            'experience_category'             => 'required|in:Line,Local',
            'previous_legal_case'             => 'required|in:Yes,No',
            
            'previous_legal_case_comment'     => 'required_if:previous_legal_case,Yes',
            
            'previous_city_id'                => 'required_if:previous_legal_case,Yes|nullable|exists:cities,id',
            'previous_police_station'         => 'required_if:previous_legal_case,Yes|nullable|string|max:255',
            
            'previous_notes'                  => 'required',
        ], [
            'required' => 'This field is required.',
            'max'      => 'Maximum 100 characters allowed.',
            'unique'   => 'This value already exists.',
            'numeric'  => 'Only numeric values are allowed.',
            'min'      => 'Value must be at least :min.',
            'max'      => 'Maximum allowed value is :max.',
            'in'       => 'Invalid selection.',
        ]);
        
        
        if ($validator->fails()) {
            // \Log::error('Validation failed', [
            //     'errors' => $validator->errors()->toArray(),
            //     //'input' => request()->all(), // optional: log the input data for context
            // ]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.',
            ], 422);
        }
            
            
        try {
            
            $empWorkExp = null;
            
            DB::transaction(function () use ($request, $empWorkExp) {
                
                $startDate = null;
                $endDate   = null;
                if ($request->previous_employment_duration) {
                    // Split by " - " with spaces around the dash
                    $dates = explode(' - ', $request->previous_employment_duration);
                
                    if (count($dates) === 2) {
                        $startDate = Carbon::parse(trim($dates[0]))->format('Y-m-d');
                        $endDate   = Carbon::parse(trim($dates[1]))->format('Y-m-d');
                    }
                }
                
                $empWorkExp  = new Employeeworkexperience;
                $empWorkExp->contact_id = $request->contact_id;
                $empWorkExp->experience_category = $request->experience_category;
                $empWorkExp->previous_company_name   = $request->previous_company_name;
                $empWorkExp->designation   = $request->previous_designation;
                $empWorkExp->employment_start_date   = $startDate;
                $empWorkExp->employment_end_date   = $endDate;
                $empWorkExp->exit_reason = $request->previous_exit_reason;
                $empWorkExp->salary = $request->previous_salary;
                $empWorkExp->any_legal_case = $request->previous_legal_case;
                $empWorkExp->comment_about_case = $request->previous_legal_case_comment;
                $empWorkExp->city_id = $request->previous_city_id;
                $empWorkExp->police_station = $request->previous_police_station;
                $empWorkExp->notes = $request->previous_notes;
                
                $empWorkExp->created_by = Auth::user()->id;
                $empWorkExp->save();
                
                // Log activity
                $description = 'Driver [ID: '.$request->contact_id.'] work experience added.';
                $this->storeUseractivity(52, 3, Auth::user()->id, $empWorkExp->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Work experience added successfully.';
    
        } catch (\Exception $exp) {
            
            \Log::error('Save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $empWorkExp, 'message' => $respmessage]);
    
    }
    
    
    
    public function getDriverJoiningLetter($id){
        
        $contact = Contact::with([
             'organisation',
             'country.states',
             'state.cities',
             'relcontacts',
             'coaddresses',
             'bank',
             'driverinfo',
             'employeeAssets',
             'assetLogs',
             'workExperiences',
             'salaries',
             'employeeExitDetail',
             'activities',
             'activities.createdBy',
         ])
         ->where('cotype_id',self::CONTACT_TYPE_DRIVER)
         ->where('id',$id)
         ->firstOrFail();
         
        $departments = Department::orderBy('name')->get();
        
        return view('contacts.driver.joining-letter',compact('contact','departments'));
        
    }
    
    
    public function getDriverExitLetter($id){  
        
        $contact = Contact::with([
             'organisation',
             'country.states',
             'state.cities',
             'relcontacts',
             'coaddresses',
             'bank',
             'employeeAssets',
             'assetLogs',
             'workExperiences',
             'salaries',
             'employeeExitDetail',
             'activities',
             'activities.createdBy',
         ])
         ->where('cotype_id',self::CONTACT_TYPE_DRIVER)
         ->where('id',$id)
         ->firstOrFail();
         
        $departments = Department::orderBy('name')->get();  
        
        return view('contacts.driver.exit-letter',compact('contact','departments'));
    }
    
    
    public function storeDriverExitDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_id'  => 'required|exists:contacts,id',
            'exit_reason' => 'required|string',
            'exit_date'   => 'required|date|before_or_equal:today',
            'exit_feedback' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            
            // \Log::error('Validation failed', [
            //     'errors' => $validator->errors()->toArray(),
            //     //'input' => request()->all(),
            // ]);
            
            
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }
        
        
        if (Employeeexitdetail::where('contact_id', $request->contact_id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Exit details already exist for this employee.'
            ]);
        }
    
        
    
        try {
            
            $exitDetails = null;
            
            DB::transaction(function () use ($request, &$exitDetails) {
                
                $exitDetails = new Employeeexitdetail();
                $exitDetails->contact_id = $request->contact_id;
                $exitDetails->exit_reason = $request->exit_reason;
                $exitDetails->exit_date = $request->exit_date;
                $exitDetails->feedback = $request->exit_feedback;
                
                $exitDetails->created_by = Auth::user()->id;
                $exitDetails->save();
                
                // Log user activity
                //$this->storeUseractivity(42, 3, Auth::user()->id, $tollstation->id, 'Added new Toll Station.');
            });
            
            $success = true;
            $respmessage = 'Exit detail saved successfully.';
    
    
        } catch (\Exception $exp) {
            
            // \Log::error('Process save error', [
            //     'message' => $exp->getMessage(),
            //     'trace' => $exp->getTraceAsString()
            // ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $exitDetails, 'message' => $respmessage]);
    }
    
    
    public function updateDriverLetterSeenStatus(Request $request)
    {
        try {
    
            $contact = Contact::findOrFail($request->contact_id);
    
            if ($request->type === 'joining-letter') {
                $contact->joining_letter_seen_status = $request->seen_status;
            }
    
            if ($request->type === 'exit-letter') {
                $contact->exit_letter_seen_status = $request->seen_status;
            }
    
            $contact->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Seen status updated successfully.'
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
    // Vehicle Vendor Section ------------------------------------------------------------------------------------------------
    
    public function vehiclevendorList(Request $request): View
    {
        $cotypeId = self::CONTACT_TYPE_VEHICLE_VENDOR;
        
        
        // Filter 
        $search_name     = $request->name;
        $search_city     = $request->city;
        $search_size     = $request->size;
        $search_city = $request->city;
        $search_rag      = $request->rag;
        
        
        
        $contacts = Contact::query()->where('cotype_id', $cotypeId);

        // Filter by Name
        if ($request->filled('name')) {
            $contacts->where('contact_name', 'like', '%' . $request->name . '%');
        }
    
        // Filter by City
        if ($request->filled('city')) {
            $contacts->where('city_id', $request->city);
        }
    
        // Filter by Size
        if ($request->filled('size')) {
            $contacts->where('size', $request->size);
        }
        
        // Filter by RAG
        if ($request->filled('rag')) {
            $contacts->where('rag_status', $request->rag);
        }
        
        // Filter by Location (IMPORTANT FIX)
        if ($request->filled('city')) {
            $contacts->where('city_id', $request->city);
        }
        
        // Load relationships
        $contacts = $contacts
                            ->with([
                                'cotype',
                                'relcontacts'
                            ])
                            ->orderBy('id', 'desc')
                            ->paginate(10)
                            ->withQueryString();
        
        $cotypes   = Cotype::all();
        $cotype    = $cotypes->firstWhere('id', self::CONTACT_TYPE_VEHICLE_VENDOR);
        
        $cities = City::whereHas('state.country', function ($q) {
                            $q->where('iso2', 'IN');   
                        })->orderBy('name')->get();
                        
        
        //dd($contacts);
        
        
        return view('contacts.vehiclevendor.index', compact('contacts','cities','cotype','search_name','search_city','search_size','search_city','search_rag')); 
       
    }
    
    
    public function createVehiclevendor(Request $request){
        
        $organisation_id = optional(Auth::user()->organisation)->id;
        
        $countries = Country::all();
        
        $states = State::whereHas('country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
                        
                        
        $cotypes   = Cotype::all();
        $customerabouttype = Customerabouttype::orderBy('name')->get();
        
        $gsttreats = Gsttreat::all();
        $coattachtypes = Coattachtype::all();       
        $cotype        = $cotypes->firstWhere('id', self::CONTACT_TYPE_VEHICLE_VENDOR);
        
        $vehicle_ownership_type = Vehicleownership::where('organisation_id', $organisation_id)->where('status', 'Active')->orderBy('name')->get();
        $pan_statuses = Panstatus::where('organisation_id', $organisation_id)->orderBy('name')->get();
        
        $banks = Bank::orderBy('name')->get();
        
        return view('contacts.vehiclevendor.create',compact('customerabouttype','countries','states','cotype','cotypes','gsttreats','coattachtypes','vehicle_ownership_type','pan_statuses', 'banks')); 
    }
    
    
    public function storeVehiclevendor(Request $request){ 
        
        $request->merge([
            'phone'    => preg_replace('/\s+/', '', $request->phone),
            'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp),
        ]);


        $validate_phone = function ($attribute, $value, $fail) use ($request) {
            $code = $request->phone_code ?? getPhoneCode();
        
            if (!$code) {
                //$fail('Phone number required country code to be selected.');
            }
        
            if (Contact::where('phone', $value)->where('ph_prefix', $code)->exists()) {
                $fail('This phone number already exists.');
            }
        };
        
        $validate_whatsapp = function ($attribute, $value, $fail) use ($request) {
            if (!$value) return;
        
            $code = $request->whatsapp_code ?? getPhoneCode();
        
            if (!$code) {
                //$fail('WhatsApp number required country code to be selected.');
            }
        };

        
        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) use ($request) {
            $index = explode('.', $attribute)[1] ?? null;
            $code = $request->get('contact_person_ph_code')[$index];
            if($code === NULL){
                //$fail('Phone number required country code to be selected.');
            }
        };
        
        // if (User::where('email', $request->email)->exists()) {
        //     $fail('This email id already exists.');
        // }
        
        $validator = Validator::make($request->all(), [
            'company_name'        => 'required|max:100',
            'contact_name'        => 'required|max:100',
            'contact_code'        => 'required|max:100',
            'no_of_vehicles'      => 'nullable|max:100',
            //'phone_code'        => 'nullable|exists:countries,ph_code',
            'phone'               => ['required','digits:10',$validate_phone],
            //'whatsapp_code'     => 'nullable|exists:countries,ph_code',
            'whatsapp'            => ['nullable','digits:10',$validate_whatsapp],
            'rag_status'          => 'nullable|in:Red,Yellow,Green',
            'status'              => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'    => 'required_if:status,Blacklisted',
            'contact_comment'     => 'nullable|string|max:255',
            'size'                => 'nullable|in:Small,Medium,Large',
            
            'full_company_name'   => 'nullable|max:100',
            'vehicle_ownership_type_id'   => 'nullable|integer|exists:vehicleownerships,id',
            'company_owner'       => 'nullable|max:100',
            'company_registration_no' => 'nullable|max:100',
            'company_registration_date' => 'nullable|date|before_or_equal:today',
            'working_since'     => 'nullable|date|before_or_equal:today',
            'pan_no'            => 'nullable|max:100',
            'pan_status_id'     => 'nullable|integer|exists:panstatuses,id',
            'gst_treatment'     => 'nullable|in:Registered,Unregistered',
            'gst_number'        => 'nullable|required_if:gst_treatment,Registered',
            'tds_percentage'    => 'nullable|numeric|min:0|max:100',
            //'gst_number'        => 'nullable|required_if:gst_treatment,Registered|regex:/^[0-9A-Z]{15}$/',
            
            'address'                       => 'required|string|max:1000',
            'state_id'                      => 'required|exists:states,id',
            'city_id'                       => 'required|exists:cities,id',
            'post_code'                     => 'required|digits:6',
            'additional_info'               => 'nullable|string|max:10000',
            
            
            'is_primary' => 'required|array',
            'is_primary.*' => 'required|in:Yes,No',
            
            'bank_id' => 'required|array',
            'bank_id.*' => 'required|exists:banks,id',
            
            'beneficiary_name' => 'nullable|array',
            'beneficiary_name.*' => 'nullable|string|max:255',
            
            'account_number' => 'required|array',
            'account_number.*' => 'required|string|max:50',

            
            'ifsc_code' => 'required|array',
            'ifsc_code.*' => 'required|string|max:20',
            
            'upi_id' => 'nullable|array',
            'upi_id.*' => 'nullable|string|max:100',
            
            
            'contact_person_name'         => 'required|array|min:1',
            'contact_person_name.*'       => 'required|string|distinct|min:1',
            'contact_person_designation'  => 'required|array|min:1',
            'contact_person_designation.*'=> 'required|string|min:1',
            'contact_person_ph_code'      => 'nullable|array|min:1',
            //'contact_person_ph_code.*'       => 'nullable|string|exists:countries,ph_code',
            'contact_person_phone'             => 'required|array|min:1',
            'contact_person_phone.*'           => ['required','string','distinct',$validate_cp_phone],
            'contact_person_whatsapp_code'     => 'nullable|array|min:1',
            //'contact_person_whatsapp_code.*' => 'nullable|string|exists:countries,ph_code',
            'contact_person_whatsapp'          => 'nullable|array|min:1',
            'contact_person_whatsapp.*'        => ['nullable','string','distinct',$validate_cp_phone],
            'contact_person_email'             => 'nullable|array|min:1',
            'contact_person_email.*'           => 'nullable|email:rfc,dns|distinct',
            'contact_person_comment'           => 'nullable|array|min:1',
            'contact_person_comment.*'         => 'nullable|string|distinct|min:1',
            
            
            // Attachment validation
            'attachtypes' => 'nullable|array',
            'attachtypes.*' => 'nullable|exists:coattachtypes,id',
    
            'files' => 'nullable|array',
            'files.*' => 'nullable|array|max:2',
            'files.*.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',

            // 'coattachtypes'               => 'nullable|array|min:1',
            // 'coattachtypes.*'             => 'required|exists:coattachtypes,id',
            // 'coattachments'               => 'required|array|min:1',
            // 'coattachments.*'             => 'required|array|min:1',
            // 'coattachments.*.*'           => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
            
        ], [
                'required'             => 'This field is required.',
                'gstin.required_if'    => 'This field is required.',
                'contact_email.unique' => 'This email has already been taken.',
                'max'                  => 'Maximum 100 characters allowed.',
                'contact_comment.max'  => 'Maximum 255 characters allowed.',
                'exists'               => "This field's value is invalid.",
                'distinct'             => 'Duplicate value.',
                'email'                => 'This email is invalid.',
                // Custom field-specific messages:
                'phone.digits' => 'This field must contain 10 digits.',
                'whatsapp.digits' => 'This field must contain 10 digits.',
                'contact_person_phone.*.digits' => 'This field must contain 10 digits.',
                'contact_person_whatsapp.*.digits' => 'This field must contain 10 digits.',
            
                'contact_name.required' => 'This field is required.',
                'contact_name.max'      => 'This cannot exceed 100 characters.',
                
                
                'files.*.max' => 'You cannot upload more than 2 files.',
                'files.*.*.mimes' => 'File type must be jpg, jpeg, png or pdf.',
                'files.*.*.max' => 'File size must not exceed 2MB.',
            ]
        );
        
        
        $validator->after(function ($validator) use ($request) {

            /*
            |--------------------------------------------------------------------------
            | Primary Bank Validation
            |--------------------------------------------------------------------------
            */
            $isPrimaryArr = $request->is_primary ?? [];
        
            $primaryCount = collect($isPrimaryArr)
                ->filter(fn($val) => $val === 'Yes')
                ->count();
        
            if ($primaryCount === 0) {
                $validator->errors()->add(
                    'is_primary',
                    'At least one bank must be marked as Primary.'
                );
            }
        
            if ($primaryCount > 1) {
                $validator->errors()->add(
                    'is_primary',
                    'Only one bank can be marked as Primary.'
                );
            }
            
            
            /*
            |--------------------------------------------------------------------------
            | TDS Declaration Validation (ID = 8)
            |--------------------------------------------------------------------------
            */
            
            $tds = $request->tds_percentage;
            $attachTypes = $request->attachtypes ?? [];
            
            // CONDITION: If TDS % is 0 or 1 → TDS Declaration (ID = 8) mandatory
            if (in_array((float)$tds, [0, 1])) {
        
                if (!in_array(8, $attachTypes)) {
        
                    $validator->errors()->add(
                        'attachtypes',
                        'TDS Declaration document is mandatory when TDS % is 0 or 1.'
                    );
                }
            }
            
        
        });
        
        
        
        $errorcount = 0;
        $errors = [];
        
        
        // Conditional attachment validation
        $validator->after(function ($validator) use ($request) {
    
            $attachtypes = $request->attachtypes ?? [];
            $files = $request->file('files') ?? [];
            $usedTypes = [];
    
            foreach ($attachtypes as $key => $attachtype) {
    
                if (!$attachtype) {
                    continue;
                }
    
                if (in_array($attachtype, $usedTypes)) {
                    $validator->errors()->add(
                        "attachtypes.$key",
                        "You’ve already added this attachment type."
                    );
                }
    
                $usedTypes[] = $attachtype;
    
                if (!isset($files[$key]) || empty($files[$key])) {
                    $validator->errors()->add(
                        "files.$key",
                        "File is required when attachment type is selected."
                    );
                }
            }
        });
        
        
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            // \Log::error('Validation failed', [
            //     'errors' => $validator->errors()->toArray(),
            //     //'input' => request()->all(), // optional: log the input data for context
            // ]);
            
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
        
        
        try {
            $contact = [];
            
            DB::transaction(function () use ($request, &$contact) {
                
                $lastcontact = Contact::withTrashed()->orderBy('id', 'DESC')->first();
                if($lastcontact){
                    $lastcontactno = $lastcontact->contactno;
                    $incr_lastcontact = $lastcontactno+1;
                    if(strlen($incr_lastcontact)<5){
                        $contactno = '0';
                        for($i = 0; $i<(5-strlen($incr_lastcontact)); $i++){
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
            
                //\Log::info('Current locale:', ['p' => $phoneCode]);
            
                $contact  = new Contact;
                $contact->contactno       = $contactno;
                $contact->cotype_id       = self::CONTACT_TYPE_VEHICLE_VENDOR;
                $contact->organisation_id = optional(Auth::user()?->organisation)->id;
                $contact->contact_name    = $request->get('contact_name');
                $contact->company_name    = $request->get('company_name'); 
                $contact->contact_code    = $request->get('contact_code');
                $contact->no_of_vehicles  = $request->get('no_of_vehicles');
                
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->get('phone');
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->get('whatsapp');
                
                $contact->size            = $request->get('size');
                $contact->status          = $request->get('status') ?? 'Active';
                $contact->blacklist_reason = $request->get('blacklist_reason') ?? null;
                $contact->rag_status       = $request->get('rag_status') ?? null;
                $contact->comment          = $request->get('contact_comment');
                
                $contact->full_company_name         = $request->get('full_company_name') ?? null;
                $contact->vehicle_ownership_type_id = $request->get('vehicle_ownership_type_id') ?? null;
                $contact->company_owner             = $request->get('company_owner') ?? null;
                $contact->company_registration_no   = $request->get('company_registration_no') ?? null;
                $contact->company_registration_date = $request->get('company_registration_date') ?? null;
                $contact->working_since = $request->get('working_since') ?? null;
                $contact->pan_no = $request->get('pan_no') ?? null;
                $contact->pan_status_id = $request->get('pan_status_id') ?? null;
                $contact->gst_treatment = $request->get('gst_treatment') ?? null;
                $contact->gst_number = $request->get('gst_number') ?? null;
                $contact->tds_percentage = $request->get('tds_percentage') ?? null;
                $contact->address1 = $request->get('address') ?? null;
                $contact->state_id = $request->get('state_id') ?? null;
                $contact->city_id = $request->get('city_id') ?? null;
                $contact->zipcode = $request->get('post_code') ?? null;
                $contact->additional_info = $request->get('additional_info') ?? null;
                
                $contact->created_by         = Auth::user()->id;
                
                $contact->save();
                
                
                
                // Contact Persons + Users
                $names = $request->get('contact_person_name', []);
                for ($i = 0; $i < count($names); $i++) {
                    $name  = $names[$i] ?? null;
                    $designation = $request->get('contact_person_designation')[$i] ?? null;
                    $ph_code = $request->get('contact_person_ph_code')[$i] ?? null;
                    $phone = $request->get('contact_person_phone')[$i] ?? null;
                    
                    $whatsapp_code = $request->get('contact_person_whatsapp_code')[$i] ?? null;
                    $whatsapp = $request->get('contact_person_whatsapp')[$i] ?? null;
                    
                    $email = $request->get('contact_person_email')[$i] ?? null;
                    $comment = $request->get('contact_person_comment')[$i] ?? null;
                
                    // Skip if name, email, and phone all are empty
                    if (empty($name) && empty($email) && empty($phone)) {
                        continue;
                    }
                
                    // Always create related contact if name or phone/email present
                    $relatedContact = new Relcontact;
                    $relatedContact->contact_id = $contact->id;
                    $relatedContact->name       = $name;
                    $relatedContact->position   = $designation;
                    $relatedContact->ph_prefix  = $ph_code ?? $phoneCode;
                    $relatedContact->phone      = $phone;
                    $relatedContact->whatsapp_prefix  = $whatsapp_code ?? $phoneCode;
                    $relatedContact->whatsapp      = $whatsapp;
                    $relatedContact->email      = $email;
                    $relatedContact->comment    = $comment;
                    $relatedContact->created_by = Auth::user()->id;
                    $relatedContact->save();
                }
                
                
                
                $isPrimaryArr = $request->is_primary;
                $bankIds = $request->bank_id;
                $beneficiaryNames = $request->beneficiary_name ?? [];
                $accountNumbers = $request->account_number;
                $ifscCodes = $request->ifsc_code;
                $upiIds = $request->upi_id ?? [];
                
                for ($i = 0; $i < count($bankIds); $i++) {

                    if ($isPrimaryArr[$i] === 'Yes') {
                        // Make sure no previous bank is primary
                        Contactbank::where('contact_id', $contact->id)->update(['is_primary' => 'No']);
                    }
                
                    $bank = new Contactbank();
                    $bank->contact_id = $contact->id;
                    $bank->bank_id = $bankIds[$i];
                    $bank->is_primary = $isPrimaryArr[$i] === 'Yes' ? 'Yes' : 'No';
                    $bank->beneficiary_name = $beneficiaryNames[$i] ?? null;
                    $bank->account_number = $accountNumbers[$i];
                    $bank->ifsc_code = $ifscCodes[$i];
                    $bank->upi_id = $upiIds[$i] ?? null;
                    $bank->save();
                }
                
                


                
                $attachtypes = $request->attachtypes;
                if(!empty($attachtypes)){
                    foreach($attachtypes as $key => $attachtype){
                        if(isset($request->file('files')[$key])){
                            $files = $request->file('files')[$key];
                            
                            foreach($files as $file){
                                $fileoriginalname = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();
                                $filesize = $file->getSize();

                                // Keep original extension
                                $filename = 'contact-attachment-'.Str::random(4).'_'.time().'.'.$extension;

                                $file->move(
                                    public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR),
                                    $filename
                                );
                                
                                
                                $contact_attachment = new Coattachment;
                                $contact_attachment->name              = $filename;
                                $contact_attachment->original_name     = $fileoriginalname;
                                $contact_attachment->file_size         = ($filesize/(1024 *1024));
                                $contact_attachment->coattachtype_id   = $attachtype;
                                $contact_attachment->created_by        = Auth::id();
                                $contact_attachment->contact_id        = $contact->id;
                                $contact_attachment->save();
                            }
                        }
                    } 
                }
                
                
                // Log activity
                $description = 'Added new vehicle vendor contact with ID ' . $contact->id;
                $this->storeUseractivity(7, 3, Auth::user()->id, $contact->id, $description);

            });
        
        
            return response()->json([
                'success' => true,
                'data'    => $contact,
                'message' => 'Vehicle Vendor saved successfully.'
            ]);
            
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage()
            ]);
        }
    }
    
    
    
    public function editVehiclevendor(Request $request, $id) 
    {
        $contact = Contact::with([
             'country.states',
             'state.cities',
             'relcontacts',
             'bankDetails',
             'coattachments.coattachtype',
             'activities',
             'activities.createdBy',
         ])
         ->where('cotype_id',self::CONTACT_TYPE_VEHICLE_VENDOR)
         ->where('id',$id)
         ->first();
         
        //dd($contact);
        //dd($contact->customercontracts);
         
         
        $organisation_id = optional(Auth::user()->organisation)->id;
        
        $countries = Country::all();
        
        $states = State::whereHas('country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
                        
                        
        $cotypes   = Cotype::all();
        $customerabouttype = Customerabouttype::orderBy('name')->get();
        
        $gsttreats = Gsttreat::all();
        $coattachtypes = Coattachtype::all();       
        $cotype        = $cotypes->firstWhere('id', self::CONTACT_TYPE_VEHICLE_VENDOR);
        
        $vehicle_ownership_type = Vehicleownership::where('organisation_id', $organisation_id)->where('status', 'Active')->orderBy('name')->get();
        $pan_statuses = Panstatus::where('organisation_id', $organisation_id)->orderBy('name')->get();
        
        $banks = Bank::orderBy('name')->get();
        
  
        //dd($contractPricings);
         
        // Log activity
        $description = 'Retrieve a load vendor named '.$contact->contact_name.' to edit.';
        $useractivity = $this->storeUseractivity(7, 5, Auth::user()->id, $contact->id, $description);
         
        return view('contacts.vehiclevendor.edit', compact('contact','customerabouttype','countries','states','cotype','cotypes','gsttreats','coattachtypes','vehicle_ownership_type','pan_statuses', 'banks')); 
                                                    
    }
    
    
    
    public function updateVehiclevendor(Request $request, $id)
    {
        // === Clean phone numbers (intl-tel-input adds spaces) ===
        if ($request->has('phone')) {
            $request->merge([
                'phone' => preg_replace('/\s+/', '', $request->phone),
            ]);
        }
        
        if ($request->has('whatsapp')) {
            $request->merge([
                'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp),
            ]);
        }
        
        if ($request->has('contact_person_phone')) {
            $phones = $request->contact_person_phone;
            foreach ($phones as $k => $p) {
                $phones[$k] = preg_replace('/\s+/', '', $p);
            }
            $request->merge(['contact_person_phone' => $phones]);
        }

        
        $validate_phone = function (string $attribute, mixed $value, Closure $fail) use ($id) {

            // Always take phone code from helper (not from request)
            $code = getPhoneCode();
        
            if (!$code) {
                //$fail('Phone number requires a country code.');
            }
        
            if (
                Contact::where('phone', $value)
                    ->where('ph_prefix', $code)
                    ->where('id', '!=', $id)
                    ->exists()
            ) {
                $fail('This phone number already exists.');
            }
        };


    
        $validate_cp_email = function (string $attribute, mixed $value, Closure $fail) use ($request) {
            $index = explode('.', $attribute)[1] ?? null;
            $email = $value;
            $person_id = $request->input("contact_person_id.$index");
    
            if ($email && $email !== null) {
                $query = Contact::where('email', $email);
                if ($person_id) {
                    $query->where('id', '!=', $person_id);
                }
    
                if ($query->exists()) {
                    $fail("The email $email is already taken.");
                }
            }
        };
    
        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) {

            $code = getPhoneCode();
        
            if (!$code) {
                //$fail('Contact person phone number requires a country code.');
            }
        };

    
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_VEHICLE_VENDOR)->find($id);
    
        if (!$contact) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Contact not found!'
            ], 422);
        }
    
        $validator = Validator::make($request->all(), [
            'company_name'        => 'required|max:100',
            'contact_name'        => 'required|max:100',
            'contact_code'        => 'required|max:100',
            'no_of_vehicles'      => 'nullable|max:100',
            //'phone_code'        => 'nullable|exists:countries,ph_code',
            'phone'               => ['required','digits:10',$validate_phone],
            //'whatsapp_code'     => 'nullable|exists:countries,ph_code',
            'whatsapp'            => ['nullable','digits:10',$validate_phone],
            'rag_status'          => 'nullable|in:Red,Yellow,Green',
            'status'              => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'    => 'required_if:status,Blacklisted',
            'contact_comment'     => 'nullable|string|max:255',
            'size'                => 'nullable|in:Small,Medium,Large',
            // 'email'               => [
            //                         'nullable',
            //                         'email',
            //                         Rule::unique('contacts', 'email')->ignore($id),
            //                       ],
            'full_company_name'   => 'nullable|max:100',
            'vehicle_ownership_type_id'   => 'nullable|integer|exists:vehicleownerships,id',
            'company_owner'       => 'nullable|max:100',
            'company_registration_no' => 'nullable|max:100',
            'company_registration_date' => 'nullable|date|before_or_equal:today',
            'working_since'     => 'nullable|date|before_or_equal:today',
            'pan_no'            => 'nullable|max:100',
            'pan_status_id'     => 'nullable|integer|exists:panstatuses,id',
            'gst_treatment'     => 'nullable|in:Registered,Unregistered',
            'gst_number'        => 'nullable|required_if:gst_treatment,Registered',
            'tds_percentage'    => 'nullable|numeric|min:0|max:100',
            'address'                       => 'required|string|max:1000',
            'state_id'                      => 'required|exists:states,id',
            'city_id'                       => 'required|exists:cities,id',
            'post_code'                     => 'required|digits:6',
            'additional_info'               => 'nullable|string|max:10000',
            
            'is_primary' => 'required|array',
            'is_primary.*' => 'required|in:Yes,No',
            
            'bank_id' => 'required|array',
            'bank_id.*' => 'required|exists:banks,id',
            
            'beneficiary_name' => 'nullable|array',
            'beneficiary_name.*' => 'nullable|string|max:255',
            
            'account_number' => 'required|array',
            'account_number.*' => 'required|string|max:50',

            
            'ifsc_code' => 'required|array',
            'ifsc_code.*' => 'required|string|max:20',
            
            'upi_id' => 'nullable|array',
            'upi_id.*' => 'nullable|string|max:100',
            
            
            'contact_person_name'         => 'required|array|min:1',
            'contact_person_name.*'       => 'required|string|distinct|min:1',
            'contact_person_designation'  => 'required|array|min:1',
            'contact_person_designation.*'=> 'required|string|min:1',
            'contact_person_ph_code'      => 'nullable|array|min:1',
            //'contact_person_ph_code.*'       => 'nullable|string|exists:countries,ph_code',
            'contact_person_phone'             => 'required|array|min:1',
            'contact_person_phone.*'           => ['required','string','distinct',$validate_cp_phone],
            'contact_person_whatsapp_code'     => 'nullable|array|min:1',
            //'contact_person_whatsapp_code.*' => 'nullable|string|exists:countries,ph_code',
            'contact_person_whatsapp'          => 'nullable|array|min:1',
            'contact_person_whatsapp.*'        => ['nullable','string','distinct',$validate_cp_phone],
            'contact_person_email'             => 'nullable|array|min:1',
            'contact_person_email.*'           => 'nullable|email:rfc,dns|distinct',
            'contact_person_comment'           => 'nullable|array|min:1',
            'contact_person_comment.*'         => 'nullable|string|distinct|min:1',
            
            // Attachment validation
            'attachtypes' => 'nullable|array',
            'attachtypes.*' => 'nullable|exists:coattachtypes,id',
    
            'files' => 'nullable|array',
            'files.*' => 'nullable|array|max:2',
            'files.*.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            
            
            // 'coattachtypes'               => 'nullable|array|min:1',
            // 'coattachtypes.*'             => 'nullable|exists:coattachtypes,id',
            // 'coattachments'               => 'nullable|array|min:1',
            // 'coattachments.*'             => 'nullable|array|min:1',
            // 'coattachments.*.*'           => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
            // 'delete_coattachment_ids'     => 'sometimes|array|min:1',
            // 'delete_coattachment_ids.*'   => [
            //         'required',
            //          Rule::exists('coattachments','id')
            //          ->whereNull('deleted_at')
            //          ->where('contact_id',$contact->id)
            //  ]
        ], [
                'required'             => 'This field is required.',
                'gstin.required_if'    => 'This field is required.',
                'contact_email.unique' => 'This email has already been taken.',
                'max'                  => 'Maximum 100 characters allowed.',
                'contact_comment.max'  => 'Maximum 255 characters allowed.',
                'exists'               => "This field's value is invalid.",
                'distinct'             => 'Duplicate value.',
                'email'                => 'This email is invalid.',
                // Custom field-specific messages:
                'phone.digits' => 'This field must contain 10 digits.',
                'whatsapp.digits' => 'This field must contain 10 digits.',
                'contact_person_phone.*.digits' => 'This field must contain 10 digits.',
                'contact_person_whatsapp.*.digits' => 'This field must contain 10 digits.',
            
                'contact_name.required' => 'This field is required.',
                'contact_name.max'      => 'This cannot exceed 100 characters.',
                
                
                'files.*.max' => 'You cannot upload more than 2 files.',
                'files.*.*.mimes' => 'File type must be jpg, jpeg, png or pdf.',
                'files.*.*.max' => 'File size must not exceed 2MB.',
            ]
        );
        
        
        $validator->after(function ($validator) use ($request, $contact) {

            /*
            |--------------------------------------------------------------------------
            | Primary Bank Validation
            |--------------------------------------------------------------------------
            */
        
            $primaryCount = collect($request->is_primary ?? [])
                ->filter(fn($val) => $val === 'Yes')
                ->count();
        
            if ($primaryCount === 0) {
                $validator->errors()->add(
                    'is_primary.0',
                    'At least one bank must be marked as Primary.'
                );
            }
        
            if ($primaryCount > 1) {
                $validator->errors()->add(
                    'is_primary.0',
                    'Only one bank can be marked as Primary.'
                );
            }
        
        
            /*
            |--------------------------------------------------------------------------
            | TDS Declaration Validation (ID = 8)
            |--------------------------------------------------------------------------
            */
        
            $tds = (float) $request->tds_percentage;
        
            // Existing saved attachment type IDs
            $existingAttachTypes = Coattachment::where('contact_id', $contact->id)->pluck('coattachtype_id')->toArray();

            $newAttachTypes = $request->attachtypes ?? [];
            
            $allAttachTypes = array_map('intval', array_unique(array_merge($existingAttachTypes, $newAttachTypes)));
            
            if ($tds === 0.0) {
                if (!in_array(8, $allAttachTypes)) {
                    $validator->errors()->add(
                        'attachtypes',
                        'TDS Declaration document is mandatory when TDS % is 0.'
                    );
                }
            }
        
            
        
        });
        
        
        
        
        
    
        $errorcount = 0;
        $errors = [];
        
        $attachtype_ids = [];
        if(isset($contact)){
            $attachtype_ids = $contact->coattachments->pluck('coattachtype_id')->toArray();
        }
        
        $attachtypes = $request->attachtypes ?? [];
        $filesInput  = $request->file('files') ?? [];
        
        $max = max(count($attachtypes), count($filesInput));
        
        $allKeys = array_unique(array_merge(
                    array_keys($attachtypes),
                    array_keys($filesInput)
                ));

        foreach ($allKeys as $key) {
        
            $attachtype = $attachtypes[$key] ?? null;
            $files      = $filesInput[$key] ?? null;
        
            // BOTH EMPTY → OK
            if (empty($attachtype) && empty($files)) {
                continue;
            }
        
            // FILE GIVEN BUT TYPE MISSING
            if (!empty($files) && empty($attachtype)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['Document type is required.'];
                continue;
            }
        
            // TYPE GIVEN BUT FILE MISSING
            if (!empty($attachtype) && empty($files)) {
                $errorcount++;
                $errors['coattachments_'.$key] = ['Please upload file.'];
                continue;
            }
        
            // DUPLICATE TYPE CHECK
            if (!empty($attachtype_ids) && in_array($attachtype, $attachtype_ids, true)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['You’ve already added this attachment type.'];
                continue;
            }
        
            $attachtype_ids[] = $attachtype;
        
            // FILE VALIDATION
            if (!empty($files)) {
        
                if (count($files) > 2) {
                    $errorcount++;
                    $errors['coattachments_'.$key] = ['You cannot upload more than 2 files.'];
                }
        
                foreach ($files as $file) {
        
                    $extension = strtolower($file->getClientOriginalExtension());
                    $size      = $file->getSize();
        
                    if (!in_array($extension, ['jpg','jpeg','png','pdf'])) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File type must be jpg, jpeg, png or pdf.'];
                    }
        
                    if ($size > 2097152) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File size must not exceed 2MB.'];
                    }
                }
            }
        }
        
        
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            \Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                //'input' => request()->all(), // optional: log the input data for context
            ]);
            
            
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
    
        try {
            
            
            DB::transaction(function () use ($request, $contact) {
                
                $phoneCode = getPhoneCode();
            
                //\Log::info('Current locale:', ['p' => $phoneCode]);
                
                
                $contact->contact_name    = $request->get('contact_name');
                $contact->company_name    = $request->get('company_name'); 
                $contact->contact_code    = $request->get('contact_code');
                $contact->no_of_vehicles  = $request->get('no_of_vehicles');
                
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->get('phone');
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->get('whatsapp');
                
                $contact->size            = $request->get('size');
                $contact->status          = $request->get('status') ?? 'Active';
               
                
                $contact->full_company_name         = $request->get('full_company_name') ?? null;
                $contact->vehicle_ownership_type_id = $request->get('vehicle_ownership_type_id') ?? null;
                $contact->company_owner             = $request->get('company_owner') ?? null;
                $contact->company_registration_no   = $request->get('company_registration_no') ?? null;
                $contact->company_registration_date = $request->get('company_registration_date') ?? null;
                $contact->working_since = $request->get('working_since') ?? null;
                $contact->pan_no = $request->get('pan_no') ?? null;
                $contact->pan_status_id = $request->get('pan_status_id') ?? null;
                $contact->gst_treatment = $request->get('gst_treatment') ?? null;
                $contact->gst_number = $request->get('gst_number') ?? null;
                $contact->tds_percentage = $request->get('tds_percentage') ?? null;
                $contact->address1 = $request->get('address') ?? null;
                $contact->state_id = $request->get('state_id') ?? null;
                $contact->city_id = $request->get('city_id') ?? null;
                $contact->zipcode = $request->get('post_code') ?? null;
                $contact->additional_info = $request->get('additional_info') ?? null;
                
                if ($request->get('status') === 'Blacklisted') {
                    $contact->blacklisted_at = now();
                }else {
                    $contact->blacklisted_at = null;
                }

                $contact->blacklist_reason = $request->get('blacklist_reason') ?? null;
                $contact->rag_status       = $request->get('rag_status') ?? null;
                $contact->comment          = $request->get('contact_comment');
                
                $contact->updated_by      = Auth::user()->id;
                $contact->save();
    
                // === Update Relcontacts ===
                $relcontact_ids = [];
                foreach ($request->contact_person_name ?? [] as $i => $name) {
                    $rel = Relcontact::find($request->contact_person_id[$i] ?? 0);
                    if (!$rel) {
                        $rel = new Relcontact();
                        $rel->contact_id = $contact->id;
                    }
                    
                    $ph_code = $request->get('contact_person_ph_code')[$i] ?? null;
                    $phone = $request->get('contact_person_phone')[$i] ?? null;
                    
                    $whatsapp_code = $request->get('contact_person_whatsapp_code')[$i] ?? null;
                    $whatsapp = $request->get('contact_person_whatsapp')[$i] ?? null;
                    
                    
                    $rel->name      = $name;
                    $rel->position  = $request->contact_person_designation[$i] ?? null;
                    $rel->ph_prefix = $ph_code ?? $phoneCode;
                    $rel->phone     = $request->contact_person_phone[$i] ?? null;
                    $rel->whatsapp_prefix = $whatsapp_code ?? $phoneCode;
                    $rel->whatsapp      = $request->contact_person_whatsapp[$i] ?? null;
                    $rel->email     = $request->contact_person_email[$i] ?? null;
                    $rel->comment   = $request->contact_person_comment[$i] ?? null;
                    $rel->updated_by = Auth::user()->id;
                    $rel->save();
    
                    $relcontact_ids[] = $rel->id;
                }
    
                Relcontact::where('contact_id', $contact->id)
                          ->whereNotIn('id', $relcontact_ids)
                          ->delete();
                          
                
                // === Update Bank Details ===

                $bankDetailIds = [];
                
                $bankIds          = $request->bank_id ?? [];
                $isPrimaryArr     = $request->is_primary ?? [];
                $beneficiaryNames = $request->beneficiary_name ?? [];
                $accountNumbers   = $request->account_number ?? [];
                $ifscCodes        = $request->ifsc_code ?? [];
                $upiIds           = $request->upi_id ?? [];
                $contactBankIds   = $request->contact_bank_id ?? []; // hidden input for existing bank row id
                
                foreach ($bankIds as $i => $bankId) {
                
                    // Find existing or create new
                    $bank = Contactbank::find($contactBankIds[$i] ?? 0);
                
                    if (!$bank) {
                        $bank = new Contactbank();
                        $bank->contact_id = $contact->id;
                    }
                
                    // If this one is primary → make others No
                    if (($isPrimaryArr[$i] ?? 'No') === 'Yes') {
                        Contactbank::where('contact_id', $contact->id)->update(['is_primary' => 'No']);
                    }
                
                    $bank->bank_id          = $bankId;
                    $bank->is_primary       = ($isPrimaryArr[$i] ?? 'No') === 'Yes' ? 'Yes' : 'No';
                    $bank->beneficiary_name = $beneficiaryNames[$i] ?? null;
                    $bank->account_number   = $accountNumbers[$i] ?? null;
                    $bank->ifsc_code        = $ifscCodes[$i] ?? null;
                    $bank->upi_id           = $upiIds[$i] ?? null;
                    $bank->save();
                
                    $bankDetailIds[] = $bank->id;
                }
                
                // Delete removed bank records
                Contactbank::where('contact_id', $contact->id)
                    ->whereNotIn('id', $bankDetailIds)
                    ->delete();
                
                
                
                          
                if ($request->filled('blacklist_reason')) {
                    $activity = new Contactactivity();
                    $activity->contact_id = $contact->id;
                    $activity->notes = $request->blacklist_reason; 
                    $activity->is_blacklisted = 'Yes';
                    $activity->created_by = Auth::user()->id;
                    $activity->save();
                }
    
                
                // === TODO: Handle Attachments (if needed) ===
                $attachtypes = $request->attachtypes;
                if(!empty($attachtypes)){
            
                    foreach($attachtypes as $key => $attachtype){
                        
                        if(isset($request->file('files')[$key])){
                            $files = $request->file('files')[$key];
                            
                            foreach($files as $file){
                                $fileoriginalname = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();
                                $filesize = $file->getSize();
                                
                                // Keep original extension
                                $filename = 'contact-attachment-'.Str::random(4).'_'.time().'.'.$extension;

                                $file->move(
                                    public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR),
                                    $filename
                                );


                                $contact_attachment = new Coattachment;
                                $contact_attachment->name              = $filename;
                                $contact_attachment->original_name     = $fileoriginalname;
                                $contact_attachment->file_size         = ($filesize/(1024 *1024));
                                $contact_attachment->coattachtype_id   = $attachtype;
                                $contact_attachment->created_by        = Auth::id();
                                $contact_attachment->contact_id        = $contact->id;
                                $contact_attachment->save();
                            }
                            
                        }
                    } 
                }
                
                
                // Log activity
                $this->storeUseractivity(7, 4, Auth::user()->id, $contact->id, 'Load Vendor Updated [ID: ' . $contact->id . '].');
                
            });
    
            return response()->json([
                'success' => true,
                'data'    => $contact,
                'message' => 'Vehicle Vendor updated successfully.'
            ]);
        } catch (\Exception $exp) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage()
            ]);
        }
    }
    
    
    
    
    // Tyre Vendor Section ------------------------------------------------------------------------------------------------
    
    public function tyreVendorList(Request $request): View
    {
        $cotypeId = self::CONTACT_TYPE_TYRE_VENDOR;
        
        
        // Filter 
        $search_name     = $request->name;
        $search_city     = $request->city;
        $search_size     = $request->size;
        $search_city = $request->city;
        
        $contacts = Contact::query()->where('cotype_id', $cotypeId);

        // Filter by Name
        if ($request->filled('name')) {
            $contacts->where('contact_name', 'like', '%' . $request->name . '%');
        }
    
        // Filter by City
        if ($request->filled('city')) {
            $contacts->where('city_id', $request->city);
        }
    
        // Filter by Size
        if ($request->filled('size')) {
            $contacts->where('size', $request->size);
        }
        
        // Filter by Location (IMPORTANT FIX)
        if ($request->filled('city')) {
            $contacts->where('city_id', $request->city);
        }
        
        // Load relationships
        $contacts = $contacts
                            ->with([
                                'cotype',
                                'relcontacts'
                            ])
                            ->orderBy('id', 'desc')
                            ->paginate(10)
                            ->withQueryString();
        
        $cotypes   = Cotype::all();
        $cotype    = $cotypes->firstWhere('id', self::CONTACT_TYPE_VEHICLE_VENDOR);
        
        $cities = City::whereHas('state.country', function ($q) {
                            $q->where('iso2', 'IN');   
                        })->orderBy('name')->get();
                        
        // Log activity
        $description = 'Retrieve a tyre vendor list';
        $useractivity = $this->storeUseractivity(59, 5, Auth::user()->id, 0, $description);
        
        
        return view('contacts.tyrevendor.index', compact('contacts','cities','cotype','search_name','search_city','search_size','search_city')); 
       
    }
    
    
    public function createTyreVendor(Request $request){
        
        $organisation_id = optional(Auth::user()->organisation)->id;
        
        $countries = Country::all();
        
        $states = State::whereHas('country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
                        
                        
        $cotypes   = Cotype::all();
        $customerabouttype = Customerabouttype::orderBy('name')->get();
        
        $gsttreats = Gsttreat::all();
        $coattachtypes = Coattachtype::all();       
        $cotype        = $cotypes->firstWhere('id', self::CONTACT_TYPE_TYRE_VENDOR);
        
        $vehicle_ownership_type = Vehicleownership::where('organisation_id', $organisation_id)->where('status', 'Active')->orderBy('name')->get();
        $pan_statuses = Panstatus::where('organisation_id', $organisation_id)->orderBy('name')->get();
        
        $banks = Bank::orderBy('name')->get();
        
        return view('contacts.tyrevendor.create',compact('customerabouttype','countries','states','cotype','cotypes','gsttreats','coattachtypes','vehicle_ownership_type','pan_statuses', 'banks')); 
    }
    
    
    public function storeTyreVendor(Request $request){ 
        
        $request->merge([
            'phone'    => preg_replace('/\s+/', '', $request->phone),
            'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp),
        ]);


        $validate_phone = function ($attribute, $value, $fail) use ($request) {
            $code = $request->phone_code ?? getPhoneCode();
        
            if (!$code) {
                //$fail('Phone number required country code to be selected.');
            }
        
            if (Contact::where('phone', $value)->where('ph_prefix', $code)->exists()) {
                $fail('This phone number already exists.');
            }
        };
        
        $validate_whatsapp = function ($attribute, $value, $fail) use ($request) {
            if (!$value) return;
        
            $code = $request->whatsapp_code ?? getPhoneCode();
        
            if (!$code) {
                //$fail('WhatsApp number required country code to be selected.');
            }
        };

        
        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) use ($request) {
            $index = explode('.', $attribute)[1] ?? null;
            $code = $request->get('contact_person_ph_code')[$index];
            if($code === NULL){
                //$fail('Phone number required country code to be selected.');
            }
        };
        
        // if (User::where('email', $request->email)->exists()) {
        //     $fail('This email id already exists.');
        // }
        
        $validator = Validator::make($request->all(), [
            'company_name'        => 'required|max:100',
            'contact_name'        => 'required|max:100',
            'contact_code'        => 'required|max:100',
            'no_of_vehicles'      => 'nullable|max:100',
            //'phone_code'        => 'nullable|exists:countries,ph_code',
            'phone'               => ['required','digits:10',$validate_phone],
            //'whatsapp_code'     => 'nullable|exists:countries,ph_code',
            'whatsapp'            => ['nullable','digits:10',$validate_whatsapp],
            'status'              => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'    => 'required_if:status,Blacklisted',
            'contact_comment'     => 'nullable|string|max:255',
            
            'full_company_name'   => 'nullable|max:100',
            'company_owner'       => 'nullable|max:100',
            'company_registration_no' => 'nullable|max:100',
            'company_registration_date' => 'nullable|date|before_or_equal:today',
            'working_since'     => 'nullable|date|before_or_equal:today',
            'pan_no'            => 'nullable|max:100',
            'pan_status_id'     => 'nullable|integer|exists:panstatuses,id',
            'gst_treatment'     => 'nullable|in:Registered,Unregistered',
            'gst_number'        => 'nullable|required_if:gst_treatment,Registered',
            'tds_percentage'    => 'nullable|numeric|min:0|max:100',
            //'gst_number'        => 'nullable|required_if:gst_treatment,Registered|regex:/^[0-9A-Z]{15}$/',
            
            'address'                       => 'required|string|max:1000',
            'state_id'                      => 'required|exists:states,id',
            'city_id'                       => 'required|exists:cities,id',
            'post_code'                     => 'required|digits:6',
            'additional_info'               => 'nullable|string|max:10000',
            
            
            'is_primary' => 'required|array',
            'is_primary.*' => 'required|in:Yes,No',
            
            'bank_id' => 'required|array',
            'bank_id.*' => 'required|exists:banks,id',
            
            'beneficiary_name' => 'nullable|array',
            'beneficiary_name.*' => 'nullable|string|max:255',
            
            'account_number' => 'required|array',
            'account_number.*' => 'required|string|max:50',

            
            'ifsc_code' => 'required|array',
            'ifsc_code.*' => 'required|string|max:20',
            
            'upi_id' => 'nullable|array',
            'upi_id.*' => 'nullable|string|max:100',
            
            
            'contact_person_name'         => 'required|array|min:1',
            'contact_person_name.*'       => 'required|string|distinct|min:1',
            'contact_person_designation'  => 'required|array|min:1',
            'contact_person_designation.*'=> 'required|string|min:1',
            'contact_person_ph_code'      => 'nullable|array|min:1',
            //'contact_person_ph_code.*'       => 'nullable|string|exists:countries,ph_code',
            'contact_person_phone'             => 'required|array|min:1',
            'contact_person_phone.*'           => ['required','string','distinct',$validate_cp_phone],
            'contact_person_whatsapp_code'     => 'nullable|array|min:1',
            //'contact_person_whatsapp_code.*' => 'nullable|string|exists:countries,ph_code',
            'contact_person_whatsapp'          => 'nullable|array|min:1',
            'contact_person_whatsapp.*'        => ['nullable','string','distinct',$validate_cp_phone],
            'contact_person_email'             => 'nullable|array|min:1',
            'contact_person_email.*'           => 'nullable|email:rfc,dns|distinct',
            'contact_person_comment'           => 'nullable|array|min:1',
            'contact_person_comment.*'         => 'nullable|string|distinct|min:1',
            
            
            // Attachment validation
            'attachtypes' => 'nullable|array',
            'attachtypes.*' => 'nullable|exists:coattachtypes,id',
    
            'files' => 'nullable|array',
            'files.*' => 'nullable|array|max:2',
            'files.*.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',

            // 'coattachtypes'               => 'nullable|array|min:1',
            // 'coattachtypes.*'             => 'required|exists:coattachtypes,id',
            // 'coattachments'               => 'required|array|min:1',
            // 'coattachments.*'             => 'required|array|min:1',
            // 'coattachments.*.*'           => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
            
        ], [
                'required'             => 'This field is required.',
                'gstin.required_if'    => 'This field is required.',
                'contact_email.unique' => 'This email has already been taken.',
                'max'                  => 'Maximum 100 characters allowed.',
                'contact_comment.max'  => 'Maximum 255 characters allowed.',
                'exists'               => "This field's value is invalid.",
                'distinct'             => 'Duplicate value.',
                'email'                => 'This email is invalid.',
                // Custom field-specific messages:
                'phone.digits' => 'This field must contain 10 digits.',
                'whatsapp.digits' => 'This field must contain 10 digits.',
                'contact_person_phone.*.digits' => 'This field must contain 10 digits.',
                'contact_person_whatsapp.*.digits' => 'This field must contain 10 digits.',
            
                'contact_name.required' => 'This field is required.',
                'contact_name.max'      => 'This cannot exceed 100 characters.',
                
                
                'files.*.max' => 'You cannot upload more than 2 files.',
                'files.*.*.mimes' => 'File type must be jpg, jpeg, png or pdf.',
                'files.*.*.max' => 'File size must not exceed 2MB.',
            ]
        );
        
        
        $validator->after(function ($validator) use ($request) {

            /*
            |--------------------------------------------------------------------------
            | Primary Bank Validation
            |--------------------------------------------------------------------------
            */
            $isPrimaryArr = $request->is_primary ?? [];
        
            $primaryCount = collect($isPrimaryArr)
                ->filter(fn($val) => $val === 'Yes')
                ->count();
        
            if ($primaryCount === 0) {
                $validator->errors()->add(
                    'is_primary',
                    'At least one bank must be marked as Primary.'
                );
            }
        
            if ($primaryCount > 1) {
                $validator->errors()->add(
                    'is_primary',
                    'Only one bank can be marked as Primary.'
                );
            }
            
            
            /*
            |--------------------------------------------------------------------------
            | TDS Declaration Validation (ID = 8)
            |--------------------------------------------------------------------------
            */
            
            $tds = $request->tds_percentage;
            $attachTypes = $request->attachtypes ?? [];
            
            // CONDITION: If TDS % is 0 or 1 → TDS Declaration (ID = 8) mandatory
            if (in_array((float)$tds, [0, 1])) {
        
                if (!in_array(8, $attachTypes)) {
        
                    $validator->errors()->add(
                        'attachtypes',
                        'TDS Declaration document is mandatory when TDS % is 0 or 1.'
                    );
                }
            }
            
        
        });
        
        
        
        $errorcount = 0;
        $errors = [];
        
        
        // Conditional attachment validation
        $validator->after(function ($validator) use ($request) {
    
            $attachtypes = $request->attachtypes ?? [];
            $files = $request->file('files') ?? [];
            $usedTypes = [];
    
            foreach ($attachtypes as $key => $attachtype) {
    
                if (!$attachtype) {
                    continue;
                }
    
                if (in_array($attachtype, $usedTypes)) {
                    $validator->errors()->add(
                        "attachtypes.$key",
                        "You’ve already added this attachment type."
                    );
                }
    
                $usedTypes[] = $attachtype;
    
                if (!isset($files[$key]) || empty($files[$key])) {
                    $validator->errors()->add(
                        "files.$key",
                        "File is required when attachment type is selected."
                    );
                }
            }
        });
        
        
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            // \Log::error('Validation failed', [
            //     'errors' => $validator->errors()->toArray(),
            //     //'input' => request()->all(), // optional: log the input data for context
            // ]);
            
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
        
        
        try {
            $contact = [];
            
            DB::transaction(function () use ($request, &$contact) {
                
                $lastcontact = Contact::withTrashed()->orderBy('id', 'DESC')->first();
                if($lastcontact){
                    $lastcontactno = $lastcontact->contactno;
                    $incr_lastcontact = $lastcontactno+1;
                    if(strlen($incr_lastcontact)<5){
                        $contactno = '0';
                        for($i = 0; $i<(5-strlen($incr_lastcontact)); $i++){
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
            
                //\Log::info('Current locale:', ['p' => $phoneCode]);
            
                $contact  = new Contact;
                $contact->contactno       = $contactno;
                $contact->cotype_id       = self::CONTACT_TYPE_TYRE_VENDOR;
                $contact->organisation_id = optional(Auth::user()?->organisation)->id;
                $contact->contact_name    = $request->get('contact_name');
                $contact->company_name    = $request->get('company_name'); 
                $contact->contact_code    = $request->get('contact_code');
                
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->get('phone');
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->get('whatsapp');
                
                // $contact->size            = $request->get('size');
                $contact->status          = $request->get('status') ?? 'Active';
                $contact->comment          = $request->get('contact_comment');
                
                $contact->full_company_name         = $request->get('full_company_name') ?? null;
                $contact->company_owner             = $request->get('company_owner') ?? null;
                $contact->company_registration_no   = $request->get('company_registration_no') ?? null;
                $contact->company_registration_date = $request->get('company_registration_date') ?? null;
                $contact->working_since = $request->get('working_since') ?? null;
                $contact->pan_no = $request->get('pan_no') ?? null;
                $contact->pan_status_id = $request->get('pan_status_id') ?? null;
                $contact->gst_treatment = $request->get('gst_treatment') ?? null;
                $contact->gst_number = $request->get('gst_number') ?? null;
                $contact->tds_percentage = $request->get('tds_percentage') ?? null;
                $contact->address1 = $request->get('address') ?? null;
                $contact->state_id = $request->get('state_id') ?? null;
                $contact->city_id = $request->get('city_id') ?? null;
                $contact->zipcode = $request->get('post_code') ?? null;
                $contact->additional_info = $request->get('additional_info') ?? null;
                
                $contact->created_by         = Auth::user()->id;
                
                $contact->save();
                
                
                
                // Contact Persons + Users
                $names = $request->get('contact_person_name', []);
                for ($i = 0; $i < count($names); $i++) {
                    $name  = $names[$i] ?? null;
                    $designation = $request->get('contact_person_designation')[$i] ?? null;
                    $ph_code = $request->get('contact_person_ph_code')[$i] ?? null;
                    $phone = $request->get('contact_person_phone')[$i] ?? null;
                    
                    $whatsapp_code = $request->get('contact_person_whatsapp_code')[$i] ?? null;
                    $whatsapp = $request->get('contact_person_whatsapp')[$i] ?? null;
                    
                    $email = $request->get('contact_person_email')[$i] ?? null;
                    $comment = $request->get('contact_person_comment')[$i] ?? null;
                
                    // Skip if name, email, and phone all are empty
                    if (empty($name) && empty($email) && empty($phone)) {
                        continue;
                    }
                
                    // Always create related contact if name or phone/email present
                    $relatedContact = new Relcontact;
                    $relatedContact->contact_id = $contact->id;
                    $relatedContact->name       = $name;
                    $relatedContact->position   = $designation;
                    $relatedContact->ph_prefix  = $ph_code ?? $phoneCode;
                    $relatedContact->phone      = $phone;
                    $relatedContact->whatsapp_prefix  = $whatsapp_code ?? $phoneCode;
                    $relatedContact->whatsapp      = $whatsapp;
                    $relatedContact->email      = $email;
                    $relatedContact->comment    = $comment;
                    $relatedContact->created_by = Auth::user()->id;
                    $relatedContact->save();
                }
                
                
                
                $isPrimaryArr = $request->is_primary;
                $bankIds = $request->bank_id;
                $beneficiaryNames = $request->beneficiary_name ?? [];
                $accountNumbers = $request->account_number;
                $ifscCodes = $request->ifsc_code;
                $upiIds = $request->upi_id ?? [];
                
                for ($i = 0; $i < count($bankIds); $i++) {

                    if ($isPrimaryArr[$i] === 'Yes') {
                        // Make sure no previous bank is primary
                        Contactbank::where('contact_id', $contact->id)->update(['is_primary' => 'No']);
                    }
                
                    $bank = new Contactbank();
                    $bank->contact_id = $contact->id;
                    $bank->bank_id = $bankIds[$i];
                    $bank->is_primary = $isPrimaryArr[$i] === 'Yes' ? 'Yes' : 'No';
                    $bank->beneficiary_name = $beneficiaryNames[$i] ?? null;
                    $bank->account_number = $accountNumbers[$i];
                    $bank->ifsc_code = $ifscCodes[$i];
                    $bank->upi_id = $upiIds[$i] ?? null;
                    $bank->save();
                }
                
                


                
                $attachtypes = $request->attachtypes;
                if(!empty($attachtypes)){
                    foreach($attachtypes as $key => $attachtype){
                        if(isset($request->file('files')[$key])){
                            $files = $request->file('files')[$key];
                            
                            foreach($files as $file){
                                $fileoriginalname = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();
                                $filesize = $file->getSize();
                                
                                // Keep original extension
                                $filename = 'contact-attachment-'.Str::random(4).'_'.time().'.'.$extension;

                                $file->move(
                                    public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR),
                                    $filename
                                );


                                $contact_attachment = new Coattachment;
                                $contact_attachment->name              = $filename;
                                $contact_attachment->original_name     = $fileoriginalname;
                                $contact_attachment->file_size         = ($filesize/(1024 *1024));
                                $contact_attachment->coattachtype_id   = $attachtype;
                                $contact_attachment->created_by        = Auth::id();
                                $contact_attachment->contact_id        = $contact->id;
                                $contact_attachment->save();
                            }
                        }
                    } 
                }
                
                
                // Log activity
                $description = 'Added new tyre vendor contact with ID ' . $contact->id;
                $this->storeUseractivity(59, 3, Auth::user()->id, $contact->id, $description);

            });
        
        
            return response()->json([
                'success' => true,
                'data'    => $contact,
                'message' => 'Tyre Vendor saved successfully.'
            ]);
            
        } catch (\Exception $exp) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage()
            ]);
        }
    }
    
    
    
    public function editTyreVendor(Request $request, $id) 
    {
        $contact = Contact::with([
             'country.states',
             'state.cities',
             'relcontacts',
             'bankDetails',
             'coattachments.coattachtype',
             'activities',
             'activities.createdBy',
         ])
         ->where('cotype_id',self::CONTACT_TYPE_TYRE_VENDOR)
         ->where('id',$id)
         ->first();
         
        $organisation_id = optional(Auth::user()->organisation)->id;
        
        $countries = Country::all();
        
        $states = State::whereHas('country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
                        
                        
        $cotypes   = Cotype::all();
        $customerabouttype = Customerabouttype::orderBy('name')->get();
        
        $gsttreats = Gsttreat::all();
        $coattachtypes = Coattachtype::all();       
        $cotype        = $cotypes->firstWhere('id', self::CONTACT_TYPE_TYRE_VENDOR);
        
        $vehicle_ownership_type = Vehicleownership::where('organisation_id', $organisation_id)->where('status', 'Active')->orderBy('name')->get();
        $pan_statuses = Panstatus::where('organisation_id', $organisation_id)->orderBy('name')->get();
        
        $banks = Bank::orderBy('name')->get();
        
        $tyres = Tyre::where('contact_id', $contact->id)->paginate(10, ['*'], 'tyre_page');
         
        // Log activity
        $description = 'Retrieve a load vendor named '.$contact->contact_name.' to edit.';
        $useractivity = $this->storeUseractivity(59, 5, Auth::user()->id, $contact->id, $description);
         
        return view('contacts.tyrevendor.edit', compact('contact','customerabouttype','countries','states','cotype','cotypes','gsttreats','coattachtypes','vehicle_ownership_type','pan_statuses', 'banks', 'tyres')); 
                                                    
    }
    
    
    
    public function updateTyreVendor(Request $request, $id)
    {
        // === Clean phone numbers (intl-tel-input adds spaces) ===
        if ($request->has('phone')) {
            $request->merge([
                'phone' => preg_replace('/\s+/', '', $request->phone),
            ]);
        }
        
        if ($request->has('whatsapp')) {
            $request->merge([
                'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp),
            ]);
        }
        
        if ($request->has('contact_person_phone')) {
            $phones = $request->contact_person_phone;
            foreach ($phones as $k => $p) {
                $phones[$k] = preg_replace('/\s+/', '', $p);
            }
            $request->merge(['contact_person_phone' => $phones]);
        }

        
        $validate_phone = function (string $attribute, mixed $value, Closure $fail) use ($id) {

            // Always take phone code from helper (not from request)
            $code = getPhoneCode();
        
            if (!$code) {
                //$fail('Phone number requires a country code.');
            }
        
            if (
                Contact::where('phone', $value)
                    ->where('ph_prefix', $code)
                    ->where('id', '!=', $id)
                    ->exists()
            ) {
                $fail('This phone number already exists.');
            }
        };


    
        $validate_cp_email = function (string $attribute, mixed $value, Closure $fail) use ($request) {
            $index = explode('.', $attribute)[1] ?? null;
            $email = $value;
            $person_id = $request->input("contact_person_id.$index");
    
            if ($email && $email !== null) {
                $query = Contact::where('email', $email);
                if ($person_id) {
                    $query->where('id', '!=', $person_id);
                }
    
                if ($query->exists()) {
                    $fail("The email $email is already taken.");
                }
            }
        };
    
        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) {

            $code = getPhoneCode();
        
            if (!$code) {
                //$fail('Contact person phone number requires a country code.');
            }
        };

    
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_TYRE_VENDOR)->find($id);
    
        if (!$contact) {
            // \Log::warning('Contact not found', [
            //     'contact_id' => $id,
            //     'cotype_id'  => self::CONTACT_TYPE_TYRE_VENDOR,
            // ]);

            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Contact not found!'
            ], 422);
        }
    
        $validator = Validator::make($request->all(), [
            'company_name'        => 'required|max:100',
            'contact_name'        => 'required|max:100',
            'contact_code'        => 'required|max:100',
            'no_of_vehicles'      => 'nullable|max:100',
            //'phone_code'        => 'nullable|exists:countries,ph_code',
            'phone'               => ['required','digits:10',$validate_phone],
            //'whatsapp_code'     => 'nullable|exists:countries,ph_code',
            'whatsapp'            => ['nullable','digits:10',$validate_phone],
            'status'              => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'    => 'required_if:status,Blacklisted',
            'contact_comment'     => 'nullable|string|max:255',
            // 'email'               => [
            //                         'nullable',
            //                         'email',
            //                         Rule::unique('contacts', 'email')->ignore($id),
            //                       ],
            'full_company_name'   => 'nullable|max:100',
            'company_owner'       => 'nullable|max:100',
            'company_registration_no' => 'nullable|max:100',
            'company_registration_date' => 'nullable|date|before_or_equal:today',
            'working_since'     => 'nullable|date|before_or_equal:today',
            'pan_no'            => 'nullable|max:100',
            'pan_status_id'     => 'nullable|integer|exists:panstatuses,id',
            'gst_treatment'     => 'nullable|in:Registered,Unregistered',
            'gst_number'        => 'nullable|required_if:gst_treatment,Registered',
            'tds_percentage'    => 'nullable|numeric|min:0|max:100',
            'address'                       => 'required|string|max:1000',
            'state_id'                      => 'required|exists:states,id',
            'city_id'                       => 'required|exists:cities,id',
            'post_code'                     => 'required|digits:6',
            'additional_info'               => 'nullable|string|max:10000',
            
            'is_primary' => 'required|array',
            'is_primary.*' => 'required|in:Yes,No',
            
            'bank_id' => 'required|array',
            'bank_id.*' => 'required|exists:banks,id',
            
            'beneficiary_name' => 'nullable|array',
            'beneficiary_name.*' => 'nullable|string|max:255',
            
            'account_number' => 'required|array',
            'account_number.*' => 'required|string|max:50',

            
            'ifsc_code' => 'required|array',
            'ifsc_code.*' => 'required|string|max:20',
            
            'upi_id' => 'nullable|array',
            'upi_id.*' => 'nullable|string|max:100',
            
            
            'contact_person_name'         => 'required|array|min:1',
            'contact_person_name.*'       => 'required|string|distinct|min:1',
            'contact_person_designation'  => 'required|array|min:1',
            'contact_person_designation.*'=> 'required|string|min:1',
            'contact_person_ph_code'      => 'nullable|array|min:1',
            //'contact_person_ph_code.*'       => 'nullable|string|exists:countries,ph_code',
            'contact_person_phone'             => 'required|array|min:1',
            'contact_person_phone.*'           => ['required','string','distinct',$validate_cp_phone],
            'contact_person_whatsapp_code'     => 'nullable|array|min:1',
            //'contact_person_whatsapp_code.*' => 'nullable|string|exists:countries,ph_code',
            'contact_person_whatsapp'          => 'nullable|array|min:1',
            'contact_person_whatsapp.*'        => ['nullable','string','distinct',$validate_cp_phone],
            'contact_person_email'             => 'nullable|array|min:1',
            'contact_person_email.*'           => 'nullable|email:rfc,dns|distinct',
            'contact_person_comment'           => 'nullable|array|min:1',
            'contact_person_comment.*'         => 'nullable|string|distinct|min:1',
            
            // Attachment validation
            'attachtypes' => 'nullable|array',
            'attachtypes.*' => 'nullable|exists:coattachtypes,id',
    
            'files' => 'nullable|array',
            'files.*' => 'nullable|array|max:2',
            'files.*.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            
            
            // 'coattachtypes'               => 'nullable|array|min:1',
            // 'coattachtypes.*'             => 'nullable|exists:coattachtypes,id',
            // 'coattachments'               => 'nullable|array|min:1',
            // 'coattachments.*'             => 'nullable|array|min:1',
            // 'coattachments.*.*'           => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
            // 'delete_coattachment_ids'     => 'sometimes|array|min:1',
            // 'delete_coattachment_ids.*'   => [
            //         'required',
            //          Rule::exists('coattachments','id')
            //          ->whereNull('deleted_at')
            //          ->where('contact_id',$contact->id)
            //  ]
        ], [
                'required'             => 'This field is required.',
                'gstin.required_if'    => 'This field is required.',
                'contact_email.unique' => 'This email has already been taken.',
                'max'                  => 'Maximum 100 characters allowed.',
                'contact_comment.max'  => 'Maximum 255 characters allowed.',
                'exists'               => "This field's value is invalid.",
                'distinct'             => 'Duplicate value.',
                'email'                => 'This email is invalid.',
                // Custom field-specific messages:
                'phone.digits' => 'This field must contain 10 digits.',
                'whatsapp.digits' => 'This field must contain 10 digits.',
                'contact_person_phone.*.digits' => 'This field must contain 10 digits.',
                'contact_person_whatsapp.*.digits' => 'This field must contain 10 digits.',
            
                'contact_name.required' => 'This field is required.',
                'contact_name.max'      => 'This cannot exceed 100 characters.',
                
                
                'files.*.max' => 'You cannot upload more than 2 files.',
                'files.*.*.mimes' => 'File type must be jpg, jpeg, png or pdf.',
                'files.*.*.max' => 'File size must not exceed 2MB.',
            ]
        );
        
        
        $validator->after(function ($validator) use ($request, $contact) {

            /*
            |--------------------------------------------------------------------------
            | Primary Bank Validation
            |--------------------------------------------------------------------------
            */
        
            $primaryCount = collect($request->is_primary ?? [])
                ->filter(fn($val) => $val === 'Yes')
                ->count();
        
            if ($primaryCount === 0) {
                $validator->errors()->add(
                    'is_primary.0',
                    'At least one bank must be marked as Primary.'
                );
            }
        
            if ($primaryCount > 1) {
                $validator->errors()->add(
                    'is_primary.0',
                    'Only one bank can be marked as Primary.'
                );
            }
        
        
            /*
            |--------------------------------------------------------------------------
            | TDS Declaration Validation (ID = 8)
            |--------------------------------------------------------------------------
            */
        
            $tds = (float) $request->tds_percentage;
        
            // Existing saved attachment type IDs
            $existingAttachTypes = Coattachment::where('contact_id', $contact->id)->pluck('coattachtype_id')->toArray();

            $newAttachTypes = $request->attachtypes ?? [];
            
            $allAttachTypes = array_map('intval', array_unique(array_merge($existingAttachTypes, $newAttachTypes)));
            
            if ($tds === 0.0) {
                if (!in_array(8, $allAttachTypes)) {
                    $validator->errors()->add(
                        'attachtypes',
                        'TDS Declaration document is mandatory when TDS % is 0.'
                    );
                }
            }
        
            
        
        });
        
        
        
        
        
    
        $errorcount = 0;
        $errors = [];
        
        $attachtype_ids = [];
        if(isset($contact)){
            $attachtype_ids = $contact->coattachments->pluck('coattachtype_id')->toArray();
        }
        
        $attachtypes = $request->attachtypes ?? [];
        $filesInput  = $request->file('files') ?? [];
        
        $max = max(count($attachtypes), count($filesInput));
        
        $allKeys = array_unique(array_merge(
                    array_keys($attachtypes),
                    array_keys($filesInput)
                ));

        foreach ($allKeys as $key) {
        
            $attachtype = $attachtypes[$key] ?? null;
            $files      = $filesInput[$key] ?? null;
        
            // BOTH EMPTY → OK
            if (empty($attachtype) && empty($files)) {
                continue;
            }
        
            // FILE GIVEN BUT TYPE MISSING
            if (!empty($files) && empty($attachtype)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['Document type is required.'];
                continue;
            }
        
            // TYPE GIVEN BUT FILE MISSING
            if (!empty($attachtype) && empty($files)) {
                $errorcount++;
                $errors['coattachments_'.$key] = ['Please upload file.'];
                continue;
            }
        
            // DUPLICATE TYPE CHECK
            if (!empty($attachtype_ids) && in_array($attachtype, $attachtype_ids, true)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['You’ve already added this attachment type.'];
                continue;
            }
        
            $attachtype_ids[] = $attachtype;
        
            // FILE VALIDATION
            if (!empty($files)) {
        
                if (count($files) > 2) {
                    $errorcount++;
                    $errors['coattachments_'.$key] = ['You cannot upload more than 2 files.'];
                }
        
                foreach ($files as $file) {
        
                    $extension = strtolower($file->getClientOriginalExtension());
                    $size      = $file->getSize();
        
                    if (!in_array($extension, ['jpg','jpeg','png','pdf'])) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File type must be jpg, jpeg, png or pdf.'];
                    }
        
                    if ($size > 2097152) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File size must not exceed 2MB.'];
                    }
                }
            }
        }
        
        
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            \Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                //'input' => request()->all(), // optional: log the input data for context
            ]);
            
            
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
    
        try {
            
            
            DB::transaction(function () use ($request, $contact) {
                
                $phoneCode = getPhoneCode();
            
                //\Log::info('Current locale:', ['p' => $phoneCode]);
                
                
                $contact->contact_name    = $request->get('contact_name');
                $contact->company_name    = $request->get('company_name'); 
                $contact->contact_code    = $request->get('contact_code');
                
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->get('phone');
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->get('whatsapp');
                
                $contact->status          = $request->get('status') ?? 'Active';
               
                
                $contact->full_company_name         = $request->get('full_company_name') ?? null;
                $contact->company_owner             = $request->get('company_owner') ?? null;
                $contact->company_registration_no   = $request->get('company_registration_no') ?? null;
                $contact->company_registration_date = $request->get('company_registration_date') ?? null;
                $contact->working_since = $request->get('working_since') ?? null;
                $contact->pan_no = $request->get('pan_no') ?? null;
                $contact->pan_status_id = $request->get('pan_status_id') ?? null;
                $contact->gst_treatment = $request->get('gst_treatment') ?? null;
                $contact->gst_number = $request->get('gst_number') ?? null;
                $contact->tds_percentage = $request->get('tds_percentage') ?? null;
                $contact->address1 = $request->get('address') ?? null;
                $contact->state_id = $request->get('state_id') ?? null;
                $contact->city_id = $request->get('city_id') ?? null;
                $contact->zipcode = $request->get('post_code') ?? null;
                $contact->additional_info = $request->get('additional_info') ?? null;
                
                if ($request->get('status') === 'Blacklisted') {
                    $contact->blacklisted_at = now();
                }else {
                    $contact->blacklisted_at = null;
                }

                $contact->blacklist_reason = $request->get('blacklist_reason') ?? null;
                $contact->comment          = $request->get('contact_comment');
                
                $contact->updated_by      = Auth::user()->id;
                $contact->save();
    
                // === Update Relcontacts ===
                $relcontact_ids = [];
                foreach ($request->contact_person_name ?? [] as $i => $name) {
                    $rel = Relcontact::find($request->contact_person_id[$i] ?? 0);
                    if (!$rel) {
                        $rel = new Relcontact();
                        $rel->contact_id = $contact->id;
                    }
                    
                    $ph_code = $request->get('contact_person_ph_code')[$i] ?? null;
                    $phone = $request->get('contact_person_phone')[$i] ?? null;
                    
                    $whatsapp_code = $request->get('contact_person_whatsapp_code')[$i] ?? null;
                    $whatsapp = $request->get('contact_person_whatsapp')[$i] ?? null;
                    
                    
                    $rel->name      = $name;
                    $rel->position  = $request->contact_person_designation[$i] ?? null;
                    $rel->ph_prefix = $ph_code ?? $phoneCode;
                    $rel->phone     = $request->contact_person_phone[$i] ?? null;
                    $rel->whatsapp_prefix = $whatsapp_code ?? $phoneCode;
                    $rel->whatsapp      = $request->contact_person_whatsapp[$i] ?? null;
                    $rel->email     = $request->contact_person_email[$i] ?? null;
                    $rel->comment   = $request->contact_person_comment[$i] ?? null;
                    $rel->updated_by = Auth::user()->id;
                    $rel->save();
    
                    $relcontact_ids[] = $rel->id;
                }
    
                Relcontact::where('contact_id', $contact->id)
                          ->whereNotIn('id', $relcontact_ids)
                          ->delete();
                          
                
                // === Update Bank Details ===

                $bankDetailIds = [];
                
                $bankIds          = $request->bank_id ?? [];
                $isPrimaryArr     = $request->is_primary ?? [];
                $beneficiaryNames = $request->beneficiary_name ?? [];
                $accountNumbers   = $request->account_number ?? [];
                $ifscCodes        = $request->ifsc_code ?? [];
                $upiIds           = $request->upi_id ?? [];
                $contactBankIds   = $request->contact_bank_id ?? []; // hidden input for existing bank row id
                
                foreach ($bankIds as $i => $bankId) {
                
                    // Find existing or create new
                    $bank = Contactbank::find($contactBankIds[$i] ?? 0);
                
                    if (!$bank) {
                        $bank = new Contactbank();
                        $bank->contact_id = $contact->id;
                    }
                
                    // If this one is primary → make others No
                    if (($isPrimaryArr[$i] ?? 'No') === 'Yes') {
                        Contactbank::where('contact_id', $contact->id)->update(['is_primary' => 'No']);
                    }
                
                    $bank->bank_id          = $bankId;
                    $bank->is_primary       = ($isPrimaryArr[$i] ?? 'No') === 'Yes' ? 'Yes' : 'No';
                    $bank->beneficiary_name = $beneficiaryNames[$i] ?? null;
                    $bank->account_number   = $accountNumbers[$i] ?? null;
                    $bank->ifsc_code        = $ifscCodes[$i] ?? null;
                    $bank->upi_id           = $upiIds[$i] ?? null;
                    $bank->save();
                
                    $bankDetailIds[] = $bank->id;
                }
                
                // Delete removed bank records
                Contactbank::where('contact_id', $contact->id)
                    ->whereNotIn('id', $bankDetailIds)
                    ->delete();
                
                
                
                          
                if ($request->filled('blacklist_reason')) {
                    $activity = new Contactactivity();
                    $activity->contact_id = $contact->id;
                    $activity->notes = $request->blacklist_reason; 
                    $activity->is_blacklisted = 'Yes';
                    $activity->created_by = Auth::user()->id;
                    $activity->save();
                }
    
                
                // === TODO: Handle Attachments (if needed) ===
                $attachtypes = $request->attachtypes;
                if(!empty($attachtypes)){
            
                    foreach($attachtypes as $key => $attachtype){
                        
                        if(isset($request->file('files')[$key])){
                            $files = $request->file('files')[$key];
                            
                            foreach($files as $file){
                                $fileoriginalname = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();
                                $filesize = $file->getSize();
                                
                                // Keep original extension
                                $filename = 'contact-attachment-'.Str::random(4).'_'.time().'.'.$extension;

                                $file->move(
                                    public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR),
                                    $filename
                                );


                                $contact_attachment = new Coattachment;
                                $contact_attachment->name              = $filename;
                                $contact_attachment->original_name     = $fileoriginalname;
                                $contact_attachment->file_size         = ($filesize/(1024 *1024));
                                $contact_attachment->coattachtype_id   = $attachtype;
                                $contact_attachment->created_by        = Auth::id();
                                $contact_attachment->contact_id        = $contact->id;
                                $contact_attachment->save();
                            }
                            
                        }
                    } 
                }
                
                
                // Log activity
                $this->storeUseractivity(59, 4, Auth::user()->id, $contact->id, 'Load Vendor Updated [ID: ' . $contact->id . '].');
                
            });
    
            return response()->json([
                'success' => true,
                'data'    => $contact,
                'message' => 'Tyre Vendor updated successfully.'
            ]);
        } catch (\Exception $exp) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage()
            ]);
        }
    }
    
    
    
    
    
    // Battery Vendor Section ------------------------------------------------------------------------------------------------

    public function batteryVendorList(Request $request): View
    {
        $cotypeId = self::CONTACT_TYPE_BATTERY_VENDOR;
        
        
        // Filter 
        $search_name     = $request->name;
        $search_city     = $request->city;
        
        $contacts = Contact::query()->where('cotype_id', $cotypeId);

        // Filter by Name
        if ($request->filled('name')) {
            $contacts->where('contact_name', 'like', '%' . $request->name . '%');
        }
    
        // Filter by City
        if ($request->filled('city')) {
            $contacts->where('city_id', $request->city);
        }
    
        
        // Load relationships
        $contacts = $contacts
                            ->with([
                                'cotype',
                                'relcontacts'
                            ])
                            ->orderBy('id', 'desc')
                            ->paginate(10)
                            ->withQueryString();
        
        $cotypes   = Cotype::all();
        $cotype    = $cotypes->firstWhere('id', self::CONTACT_TYPE_BATTERY_VENDOR);
        
        $cities = City::whereHas('state.country', function ($q) {
                            $q->where('iso2', 'IN');   
                        })->orderBy('name')->get();
                        
        // Log activity
        $description = 'Retrieve a battery vendor list';
        $useractivity = $this->storeUseractivity(69, 5, Auth::user()->id, 0, $description);
        
        
        return view('contacts.batteryvendor.index', compact('contacts','cities','cotype','search_name','search_city')); 
       
    }
    
    
    public function createBatteryVendor(Request $request){
        
        $organisation_id = optional(Auth::user()->organisation)->id;
        
        $countries = Country::all();
        
        $states = State::whereHas('country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
                        
                        
        $cotypes   = Cotype::all();
        $customerabouttype = Customerabouttype::orderBy('name')->get();
        
        $gsttreats = Gsttreat::all();
        $coattachtypes = Coattachtype::all();       
        $cotype        = $cotypes->firstWhere('id', self::CONTACT_TYPE_BATTERY_VENDOR);
        
        $vehicle_ownership_type = Vehicleownership::where('organisation_id', $organisation_id)->where('status', 'Active')->orderBy('name')->get();
        $pan_statuses = Panstatus::where('organisation_id', $organisation_id)->orderBy('name')->get();
        
        $banks = Bank::orderBy('name')->get();
        
        return view('contacts.batteryvendor.create',compact('customerabouttype','countries','states','cotype','cotypes','gsttreats','coattachtypes','vehicle_ownership_type','pan_statuses', 'banks')); 
    }
    
    public function storeBatteryVendor(Request $request){ 
        
        $request->merge([
            'phone'    => preg_replace('/\s+/', '', $request->phone),
            'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp),
        ]);


        $validate_phone = function ($attribute, $value, $fail) use ($request) {
            $code = $request->phone_code ?? getPhoneCode();
        
            if (!$code) {
                //$fail('Phone number required country code to be selected.');
            }
        
            if (Contact::where('phone', $value)->where('ph_prefix', $code)->exists()) {
                $fail('This phone number already exists.');
            }
        };
        
        $validate_whatsapp = function ($attribute, $value, $fail) use ($request) {
            if (!$value) return;
        
            $code = $request->whatsapp_code ?? getPhoneCode();
        
            if (!$code) {
                //$fail('WhatsApp number required country code to be selected.');
            }
        };

        
        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) use ($request) {
            $index = explode('.', $attribute)[1] ?? null;
            $code = $request->get('contact_person_ph_code')[$index];
            if($code === NULL){
                //$fail('Phone number required country code to be selected.');
            }
        };
        
        // if (User::where('email', $request->email)->exists()) {
        //     $fail('This email id already exists.');
        // }
        
        $validator = Validator::make($request->all(), [
            'gst_number'          => 'required|max:100',
            'company_name'        => 'required|max:100',
            'contact_name'        => 'required|max:100',
            'contact_code'        => 'required|max:100',
            'no_of_vehicles'      => 'nullable|max:100',
            //'phone_code'        => 'nullable|exists:countries,ph_code',
            'phone'               => ['required','digits:10',$validate_phone],
            //'whatsapp_code'     => 'nullable|exists:countries,ph_code',
            'whatsapp'            => ['nullable','digits:10',$validate_whatsapp],
            'status'              => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'    => 'required_if:status,Blacklisted',
            'contact_comment'     => 'nullable|string|max:255',
            
            'full_company_name'   => 'nullable|max:100',
            'company_owner'       => 'nullable|max:100',
            'company_registration_no' => 'nullable|max:100',
            'company_registration_date' => 'nullable|date|before_or_equal:today',
            'working_since'     => 'nullable|date|before_or_equal:today',
            'pan_no'            => 'nullable|max:100',
            'pan_status_id'     => 'nullable|integer|exists:panstatuses,id',
            //'gst_treatment'     => 'nullable|in:Registered,Unregistered',
            // 'gst_number'        => 'required|required_if:gst_treatment,Registered',
            'tds_percentage'    => 'nullable|numeric|min:0|max:100',
            //'gst_number'        => 'nullable|required_if:gst_treatment,Registered|regex:/^[0-9A-Z]{15}$/',
            
            'address'                       => 'required|string|max:1000',
            'state_id'                      => 'required|exists:states,id',
            'city_id'                       => 'required|exists:cities,id',
            'post_code'                     => 'required|digits:6',
            'additional_info'               => 'nullable|string|max:10000',
            
            
            'is_primary' => 'required|array',
            'is_primary.*' => 'required|in:Yes,No',
            
            'bank_id' => 'required|array',
            'bank_id.*' => 'required|exists:banks,id',
            
            'beneficiary_name' => 'nullable|array',
            'beneficiary_name.*' => 'nullable|string|max:255',
            
            'account_number' => 'required|array',
            'account_number.*' => 'required|string|max:50',

            
            'ifsc_code' => 'required|array',
            'ifsc_code.*' => 'required|string|max:20',
            
            'upi_id' => 'nullable|array',
            'upi_id.*' => 'nullable|string|max:100',
            
            
            'contact_person_name'         => 'required|array|min:1',
            'contact_person_name.*'       => 'required|string|distinct|min:1',
            'contact_person_designation'  => 'required|array|min:1',
            'contact_person_designation.*'=> 'required|string|min:1',
            'contact_person_ph_code'      => 'nullable|array|min:1',
            //'contact_person_ph_code.*'       => 'nullable|string|exists:countries,ph_code',
            'contact_person_phone'             => 'required|array|min:1',
            'contact_person_phone.*'           => ['required','string','distinct',$validate_cp_phone],
            'contact_person_whatsapp_code'     => 'nullable|array|min:1',
            //'contact_person_whatsapp_code.*' => 'nullable|string|exists:countries,ph_code',
            'contact_person_whatsapp'          => 'nullable|array|min:1',
            'contact_person_whatsapp.*'        => ['nullable','string','distinct',$validate_cp_phone],
            'contact_person_email'             => 'nullable|array|min:1',
            'contact_person_email.*'           => 'nullable|email:rfc,dns|distinct',
            'contact_person_comment'           => 'nullable|array|min:1',
            'contact_person_comment.*'         => 'nullable|string|distinct|min:1',
            
            
            // Attachment validation
            'attachtypes' => 'nullable|array',
            'attachtypes.*' => 'nullable|exists:coattachtypes,id',
    
            'files' => 'nullable|array',
            'files.*' => 'nullable|array|max:2',
            'files.*.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',

            // 'coattachtypes'               => 'nullable|array|min:1',
            // 'coattachtypes.*'             => 'required|exists:coattachtypes,id',
            // 'coattachments'               => 'required|array|min:1',
            // 'coattachments.*'             => 'required|array|min:1',
            // 'coattachments.*.*'           => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
            
        ], [
                'required'             => 'This field is required.',
                'gstin.required_if'    => 'This field is required.',
                'contact_email.unique' => 'This email has already been taken.',
                'max'                  => 'Maximum 100 characters allowed.',
                'contact_comment.max'  => 'Maximum 255 characters allowed.',
                'exists'               => "This field's value is invalid.",
                'distinct'             => 'Duplicate value.',
                'email'                => 'This email is invalid.',
                // Custom field-specific messages:
                'phone.digits' => 'This field must contain 10 digits.',
                'whatsapp.digits' => 'This field must contain 10 digits.',
                'contact_person_phone.*.digits' => 'This field must contain 10 digits.',
                'contact_person_whatsapp.*.digits' => 'This field must contain 10 digits.',
            
                'contact_name.required' => 'This field is required.',
                'contact_name.max'      => 'This cannot exceed 100 characters.',
                
                
                'files.*.max' => 'You cannot upload more than 2 files.',
                'files.*.*.mimes' => 'File type must be jpg, jpeg, png or pdf.',
                'files.*.*.max' => 'File size must not exceed 2MB.',
            ]
        );
        
        
        $validator->after(function ($validator) use ($request) {

            /*
            |--------------------------------------------------------------------------
            | Primary Bank Validation
            |--------------------------------------------------------------------------
            */
            $isPrimaryArr = $request->is_primary ?? [];
        
            $primaryCount = collect($isPrimaryArr)
                ->filter(fn($val) => $val === 'Yes')
                ->count();
        
            if ($primaryCount === 0) {
                $validator->errors()->add(
                    'is_primary',
                    'At least one bank must be marked as Primary.'
                );
            }
        
            if ($primaryCount > 1) {
                $validator->errors()->add(
                    'is_primary',
                    'Only one bank can be marked as Primary.'
                );
            }
            
            
            /*
            |--------------------------------------------------------------------------
            | TDS Declaration Validation (ID = 8)
            |--------------------------------------------------------------------------
            */
            
            $tds = $request->tds_percentage;
            $attachTypes = $request->attachtypes ?? [];
            
            // CONDITION: If TDS % is 0 or 1 → TDS Declaration (ID = 8) mandatory
            if (in_array((float)$tds, [0, 1])) {
        
                if (!in_array(8, $attachTypes)) {
        
                    $validator->errors()->add(
                        'attachtypes',
                        'TDS Declaration document is mandatory when TDS % is 0 or 1.'
                    );
                }
            }
            
        
        });
        
        
        
        $errorcount = 0;
        $errors = [];
        
        
        // Conditional attachment validation
        $validator->after(function ($validator) use ($request) {
    
            $attachtypes = $request->attachtypes ?? [];
            $files = $request->file('files') ?? [];
            $usedTypes = [];
    
            foreach ($attachtypes as $key => $attachtype) {
    
                if (!$attachtype) {
                    continue;
                }
    
                if (in_array($attachtype, $usedTypes)) {
                    $validator->errors()->add(
                        "attachtypes.$key",
                        "You’ve already added this attachment type."
                    );
                }
    
                $usedTypes[] = $attachtype;
    
                if (!isset($files[$key]) || empty($files[$key])) {
                    $validator->errors()->add(
                        "files.$key",
                        "File is required when attachment type is selected."
                    );
                }
            }
        });
        
        
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            // \Log::error('Validation failed', [
            //     'errors' => $validator->errors()->toArray(),
            //     //'input' => request()->all(), // optional: log the input data for context
            // ]);
            
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
        
        
        try {
            
            $contact = [];
            
            DB::transaction(function () use ($request, &$contact) {
                
                $lastcontact = Contact::withTrashed()->orderBy('id', 'DESC')->first();
                if($lastcontact){
                    $lastcontactno = $lastcontact->contactno;
                    $incr_lastcontact = $lastcontactno+1;
                    if(strlen($incr_lastcontact)<5){
                        $contactno = '0';
                        for($i = 0; $i<(5-strlen($incr_lastcontact)); $i++){
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
            
                //\Log::info('Current locale:', ['p' => $phoneCode]);
            
                $contact  = new Contact;
                $contact->contactno       = $contactno;
                $contact->cotype_id       = self::CONTACT_TYPE_BATTERY_VENDOR;
                $contact->organisation_id = optional(Auth::user()?->organisation)->id;
                $contact->contact_name    = $request->get('contact_name');
                $contact->company_name    = $request->get('company_name'); 
                $contact->contact_code    = $request->get('contact_code');
                
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->get('phone');
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->get('whatsapp');
                
                // $contact->size            = $request->get('size');
                $contact->status          = $request->get('status') ?? 'Active';
                $contact->comment          = $request->get('contact_comment');
                
                $contact->full_company_name         = $request->get('full_company_name') ?? null;
                $contact->company_owner             = $request->get('company_owner') ?? null;
                $contact->company_registration_no   = $request->get('company_registration_no') ?? null;
                $contact->company_registration_date = $request->get('company_registration_date') ?? null;
                $contact->working_since = $request->get('working_since') ?? null;
                $contact->pan_no = $request->get('pan_no') ?? null;
                $contact->pan_status_id = $request->get('pan_status_id') ?? null;
                $contact->gst_treatment = 'Registered' ?? null;
                //$contact->gst_treatment = $request->get('gst_treatment') ?? null;
                $contact->gst_number = $request->get('gst_number') ?? null;
                $contact->tds_percentage = $request->get('tds_percentage') ?? null;
                $contact->address1 = $request->get('address') ?? null;
                $contact->state_id = $request->get('state_id') ?? null;
                $contact->city_id = $request->get('city_id') ?? null;
                $contact->zipcode = $request->get('post_code') ?? null;
                $contact->additional_info = $request->get('additional_info') ?? null;
                
                $contact->created_by         = Auth::user()->id;
                
                $contact->save();
                
                
                
                // Contact Persons + Users
                $names = $request->get('contact_person_name', []);
                for ($i = 0; $i < count($names); $i++) {
                    $name  = $names[$i] ?? null;
                    $designation = $request->get('contact_person_designation')[$i] ?? null;
                    $ph_code = $request->get('contact_person_ph_code')[$i] ?? null;
                    $phone = $request->get('contact_person_phone')[$i] ?? null;
                    
                    $whatsapp_code = $request->get('contact_person_whatsapp_code')[$i] ?? null;
                    $whatsapp = $request->get('contact_person_whatsapp')[$i] ?? null;
                    
                    $email = $request->get('contact_person_email')[$i] ?? null;
                    $comment = $request->get('contact_person_comment')[$i] ?? null;
                
                    // Skip if name, email, and phone all are empty
                    if (empty($name) && empty($email) && empty($phone)) {
                        continue;
                    }
                
                    // Always create related contact if name or phone/email present
                    $relatedContact = new Relcontact;
                    $relatedContact->contact_id = $contact->id;
                    $relatedContact->name       = $name;
                    $relatedContact->position   = $designation;
                    $relatedContact->ph_prefix  = $ph_code ?? $phoneCode;
                    $relatedContact->phone      = $phone;
                    $relatedContact->whatsapp_prefix  = $whatsapp_code ?? $phoneCode;
                    $relatedContact->whatsapp      = $whatsapp;
                    $relatedContact->email      = $email;
                    $relatedContact->comment    = $comment;
                    $relatedContact->created_by = Auth::user()->id;
                    $relatedContact->save();
                }
                
                
                
                $isPrimaryArr = $request->is_primary;
                $bankIds = $request->bank_id;
                $beneficiaryNames = $request->beneficiary_name ?? [];
                $accountNumbers = $request->account_number;
                $ifscCodes = $request->ifsc_code;
                $upiIds = $request->upi_id ?? [];
                
                for ($i = 0; $i < count($bankIds); $i++) {

                    if ($isPrimaryArr[$i] === 'Yes') {
                        // Make sure no previous bank is primary
                        Contactbank::where('contact_id', $contact->id)->update(['is_primary' => 'No']);
                    }
                
                    $bank = new Contactbank();
                    $bank->contact_id = $contact->id;
                    $bank->bank_id = $bankIds[$i];
                    $bank->is_primary = $isPrimaryArr[$i] === 'Yes' ? 'Yes' : 'No';
                    $bank->beneficiary_name = $beneficiaryNames[$i] ?? null;
                    $bank->account_number = $accountNumbers[$i];
                    $bank->ifsc_code = $ifscCodes[$i];
                    $bank->upi_id = $upiIds[$i] ?? null;
                    $bank->save();
                }
                
                


                
                $attachtypes = $request->attachtypes;
                if(!empty($attachtypes)){
                    foreach($attachtypes as $key => $attachtype){
                        if(isset($request->file('files')[$key])){
                            $files = $request->file('files')[$key];
                            
                            foreach($files as $file){
                                $fileoriginalname = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();
                                $filesize = $file->getSize();
                                
                                // Keep original extension
                                $filename = 'contact-attachment-'.Str::random(4).'_'.time().'.'.$extension;

                                $file->move(
                                    public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR),
                                    $filename
                                );


                                $contact_attachment = new Coattachment;
                                $contact_attachment->name              = $filename;
                                $contact_attachment->original_name     = $fileoriginalname;
                                $contact_attachment->file_size         = ($filesize/(1024 *1024));
                                $contact_attachment->coattachtype_id   = $attachtype;
                                $contact_attachment->created_by        = Auth::id();
                                $contact_attachment->contact_id        = $contact->id;
                                $contact_attachment->save();
                            }
                        }
                    } 
                }
                
                
                // Log activity
                $description = 'Added new battery vendor contact with ID ' . $contact->id;
                $this->storeUseractivity(69, 3, Auth::user()->id, $contact->id, $description);

            });
        
        
            return response()->json([
                'success' => true,
                'data'    => $contact,
                'message' => 'Battery Vendor saved successfully.'
            ]);
            
        } catch (\Exception $exp) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage()
            ]);
        }
    }
    
    
    public function editBatteryVendor(Request $request, $id) 
    {
        $contact = Contact::with([
             'country.states',
             'state.cities',
             'relcontacts',
             'bankDetails',
             'coattachments.coattachtype',
             'activities',
             'activities.createdBy',
         ])
         ->where('cotype_id',self::CONTACT_TYPE_BATTERY_VENDOR)
         ->where('id',$id)
         ->first();
         
        $organisation_id = optional(Auth::user()->organisation)->id;
        
        $countries = Country::all();
        
        $states = State::whereHas('country', function ($q) {
                            $q->where('iso2', 'IN');
                        })
                        ->orderBy('name')
                        ->get();
                        
                        
        $cotypes   = Cotype::all();
        $customerabouttype = Customerabouttype::orderBy('name')->get();
        
        $gsttreats = Gsttreat::all();
        $coattachtypes = Coattachtype::all();       
        $cotype        = $cotypes->firstWhere('id', self::CONTACT_TYPE_BATTERY_VENDOR);
        
        $vehicle_ownership_type = Vehicleownership::where('organisation_id', $organisation_id)->where('status', 'Active')->orderBy('name')->get();
        $pan_statuses = Panstatus::where('organisation_id', $organisation_id)->orderBy('name')->get();
        
        $banks = Bank::orderBy('name')->get();
        
        //$tyres = Tyre::where('contact_id', $contact->id)->paginate(10, ['*'], 'tyre_page');
         
        // Log activity
        $description = 'Retrieve a load vendor named '.$contact->contact_name.' to edit.';
        $useractivity = $this->storeUseractivity(69, 5, Auth::user()->id, $contact->id, $description);
         
        return view('contacts.batteryvendor.edit', compact('contact','customerabouttype','countries','states','cotype','cotypes','gsttreats','coattachtypes','vehicle_ownership_type','pan_statuses', 'banks')); 
                                                    
    }
    
    
    public function updateBatteryVendor(Request $request, $id)
    {
        // === Clean phone numbers (intl-tel-input adds spaces) ===
        if ($request->has('phone')) {
            $request->merge([
                'phone' => preg_replace('/\s+/', '', $request->phone),
            ]);
        }
        
        if ($request->has('whatsapp')) {
            $request->merge([
                'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp),
            ]);
        }
        
        if ($request->has('contact_person_phone')) {
            $phones = $request->contact_person_phone;
            foreach ($phones as $k => $p) {
                $phones[$k] = preg_replace('/\s+/', '', $p);
            }
            $request->merge(['contact_person_phone' => $phones]);
        }

        
        $validate_phone = function (string $attribute, mixed $value, Closure $fail) use ($id) {

            // Always take phone code from helper (not from request)
            $code = getPhoneCode();
        
            if (!$code) {
                //$fail('Phone number requires a country code.');
            }
        
            if (
                Contact::where('phone', $value)
                    ->where('ph_prefix', $code)
                    ->where('id', '!=', $id)
                    ->exists()
            ) {
                $fail('This phone number already exists.');
            }
        };


    
        $validate_cp_email = function (string $attribute, mixed $value, Closure $fail) use ($request) {
            $index = explode('.', $attribute)[1] ?? null;
            $email = $value;
            $person_id = $request->input("contact_person_id.$index");
    
            if ($email && $email !== null) {
                $query = Contact::where('email', $email);
                if ($person_id) {
                    $query->where('id', '!=', $person_id);
                }
    
                if ($query->exists()) {
                    $fail("The email $email is already taken.");
                }
            }
        };
    
        $validate_cp_phone = function (string $attribute, mixed $value, Closure $fail) {

            $code = getPhoneCode();
        
            if (!$code) {
                //$fail('Contact person phone number requires a country code.');
            }
        };

    
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_BATTERY_VENDOR)->find($id);
    
        if (!$contact) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Contact not found!'
            ], 422);
        }
    
        $validator = Validator::make($request->all(), [
            //'gst_number'          => 'required|max:100',
            'gst_number' => [
                                'required',
                                'string',
                                'min:1',
                                'max:100',
                                function ($attr, $value, $fail) {
                                    if (trim($value) === '') {
                                        $fail('GST Number is required.');
                                    }
                                }
                            ],
            'company_name'        => 'required|max:100',
            'contact_name'        => 'required|max:100',
            'contact_code'        => 'required|max:100',
            'no_of_vehicles'      => 'nullable|max:100',
            //'phone_code'        => 'nullable|exists:countries,ph_code',
            'phone'               => ['required','digits:10',$validate_phone],
            //'whatsapp_code'     => 'nullable|exists:countries,ph_code',
            'whatsapp'            => ['nullable','digits:10',$validate_phone],
            'status'              => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'    => 'required_if:status,Blacklisted',
            'contact_comment'     => 'nullable|string|max:255',
            // 'email'               => [
            //                         'nullable',
            //                         'email',
            //                         Rule::unique('contacts', 'email')->ignore($id),
            //                       ],
            'full_company_name'   => 'nullable|max:100',
            'company_owner'       => 'nullable|max:100',
            'company_registration_no' => 'nullable|max:100',
            'company_registration_date' => 'nullable|date|before_or_equal:today',
            'working_since'     => 'nullable|date|before_or_equal:today',
            'pan_no'            => 'nullable|max:100',
            'pan_status_id'     => 'nullable|integer|exists:panstatuses,id',
            //'gst_treatment'     => 'nullable|in:Registered,Unregistered',
            //'gst_number'        => 'nullable|required_if:gst_treatment,Registered',
            'tds_percentage'    => 'nullable|numeric|min:0|max:100',
            'address'                       => 'required|string|max:1000',
            'state_id'                      => 'required|exists:states,id',
            'city_id'                       => 'required|exists:cities,id',
            'post_code'                     => 'required|digits:6',
            'additional_info'               => 'nullable|string|max:10000',
            
            'is_primary' => 'required|array',
            'is_primary.*' => 'required|in:Yes,No',
            
            'bank_id' => 'required|array',
            'bank_id.*' => 'required|exists:banks,id',
            
            'beneficiary_name' => 'nullable|array',
            'beneficiary_name.*' => 'nullable|string|max:255',
            
            'account_number' => 'required|array',
            'account_number.*' => 'required|string|max:50',

            
            'ifsc_code' => 'required|array',
            'ifsc_code.*' => 'required|string|max:20',
            
            'upi_id' => 'nullable|array',
            'upi_id.*' => 'nullable|string|max:100',
            
            
            'contact_person_name'         => 'required|array|min:1',
            'contact_person_name.*'       => 'required|string|distinct|min:1',
            'contact_person_designation'  => 'required|array|min:1',
            'contact_person_designation.*'=> 'required|string|min:1',
            'contact_person_ph_code'      => 'nullable|array|min:1',
            //'contact_person_ph_code.*'       => 'nullable|string|exists:countries,ph_code',
            'contact_person_phone'             => 'required|array|min:1',
            'contact_person_phone.*'           => ['required','string','distinct',$validate_cp_phone],
            'contact_person_whatsapp_code'     => 'nullable|array|min:1',
            //'contact_person_whatsapp_code.*' => 'nullable|string|exists:countries,ph_code',
            'contact_person_whatsapp'          => 'nullable|array|min:1',
            'contact_person_whatsapp.*'        => ['nullable','string','distinct',$validate_cp_phone],
            'contact_person_email'             => 'nullable|array|min:1',
            'contact_person_email.*'           => 'nullable|email:rfc,dns|distinct',
            'contact_person_comment'           => 'nullable|array|min:1',
            'contact_person_comment.*'         => 'nullable|string|distinct|min:1',
            
            // Attachment validation
            'attachtypes' => 'nullable|array',
            'attachtypes.*' => 'nullable|exists:coattachtypes,id',
    
            'files' => 'nullable|array',
            'files.*' => 'nullable|array|max:2',
            'files.*.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            
            
            // 'coattachtypes'               => 'nullable|array|min:1',
            // 'coattachtypes.*'             => 'nullable|exists:coattachtypes,id',
            // 'coattachments'               => 'nullable|array|min:1',
            // 'coattachments.*'             => 'nullable|array|min:1',
            // 'coattachments.*.*'           => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
            // 'delete_coattachment_ids'     => 'sometimes|array|min:1',
            // 'delete_coattachment_ids.*'   => [
            //         'required',
            //          Rule::exists('coattachments','id')
            //          ->whereNull('deleted_at')
            //          ->where('contact_id',$contact->id)
            //  ]
        ], [
                'required'             => 'This field is required.',
                'gstin.required_if'    => 'This field is required.',
                'contact_email.unique' => 'This email has already been taken.',
                'max'                  => 'Maximum 100 characters allowed.',
                'contact_comment.max'  => 'Maximum 255 characters allowed.',
                'exists'               => "This field's value is invalid.",
                'distinct'             => 'Duplicate value.',
                'email'                => 'This email is invalid.',
                // Custom field-specific messages:
                'phone.digits' => 'This field must contain 10 digits.',
                'whatsapp.digits' => 'This field must contain 10 digits.',
                'contact_person_phone.*.digits' => 'This field must contain 10 digits.',
                'contact_person_whatsapp.*.digits' => 'This field must contain 10 digits.',
            
                'contact_name.required' => 'This field is required.',
                'contact_name.max'      => 'This cannot exceed 100 characters.',
                
                
                'files.*.max' => 'You cannot upload more than 2 files.',
                'files.*.*.mimes' => 'File type must be jpg, jpeg, png or pdf.',
                'files.*.*.max' => 'File size must not exceed 2MB.',
            ]
        );
        
        
        $validator->after(function ($validator) use ($request, $contact) {

            /*
            |--------------------------------------------------------------------------
            | Primary Bank Validation
            |--------------------------------------------------------------------------
            */
        
            $primaryCount = collect($request->is_primary ?? [])
                ->filter(fn($val) => $val === 'Yes')
                ->count();
        
            if ($primaryCount === 0) {
                $validator->errors()->add(
                    'is_primary.0',
                    'At least one bank must be marked as Primary.'
                );
            }
        
            if ($primaryCount > 1) {
                $validator->errors()->add(
                    'is_primary.0',
                    'Only one bank can be marked as Primary.'
                );
            }
        
        
            /*
            |--------------------------------------------------------------------------
            | TDS Declaration Validation (ID = 8)
            |--------------------------------------------------------------------------
            */
        
            $tds = (float) $request->tds_percentage;
        
            // Existing saved attachment type IDs
            $existingAttachTypes = Coattachment::where('contact_id', $contact->id)->pluck('coattachtype_id')->toArray();

            $newAttachTypes = $request->attachtypes ?? [];
            
            $allAttachTypes = array_map('intval', array_unique(array_merge($existingAttachTypes, $newAttachTypes)));
            
            if ($tds === 0.0) {
                if (!in_array(8, $allAttachTypes)) {
                    $validator->errors()->add(
                        'attachtypes',
                        'TDS Declaration document is mandatory when TDS % is 0.'
                    );
                }
            }
        
            
        
        });
        
        
        
        
        
    
        $errorcount = 0;
        $errors = [];
        
        $attachtype_ids = [];
        if(isset($contact)){
            $attachtype_ids = $contact->coattachments->pluck('coattachtype_id')->toArray();
        }
        
        $attachtypes = $request->attachtypes ?? [];
        $filesInput  = $request->file('files') ?? [];
        
        $max = max(count($attachtypes), count($filesInput));
        
        $allKeys = array_unique(array_merge(
                    array_keys($attachtypes),
                    array_keys($filesInput)
                ));

        foreach ($allKeys as $key) {
        
            $attachtype = $attachtypes[$key] ?? null;
            $files      = $filesInput[$key] ?? null;
        
            // BOTH EMPTY → OK
            if (empty($attachtype) && empty($files)) {
                continue;
            }
        
            // FILE GIVEN BUT TYPE MISSING
            if (!empty($files) && empty($attachtype)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['Document type is required.'];
                continue;
            }
        
            // TYPE GIVEN BUT FILE MISSING
            if (!empty($attachtype) && empty($files)) {
                $errorcount++;
                $errors['coattachments_'.$key] = ['Please upload file.'];
                continue;
            }
        
            // DUPLICATE TYPE CHECK
            if (!empty($attachtype_ids) && in_array($attachtype, $attachtype_ids, true)) {
                $errorcount++;
                $errors['coattachtype_'.$key] = ['You’ve already added this attachment type.'];
                continue;
            }
        
            $attachtype_ids[] = $attachtype;
        
            // FILE VALIDATION
            if (!empty($files)) {
        
                if (count($files) > 2) {
                    $errorcount++;
                    $errors['coattachments_'.$key] = ['You cannot upload more than 2 files.'];
                }
        
                foreach ($files as $file) {
        
                    $extension = strtolower($file->getClientOriginalExtension());
                    $size      = $file->getSize();
        
                    if (!in_array($extension, ['jpg','jpeg','png','pdf'])) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File type must be jpg, jpeg, png or pdf.'];
                    }
        
                    if ($size > 2097152) {
                        $errorcount++;
                        $errors['coattachments_'.$key] = ['File size must not exceed 2MB.'];
                    }
                }
            }
        }
        
        
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        
        if ($validator->fails() || $errorcount > 0) {

            $allErrors = $validator->errors()->toArray();
        
            foreach ($errors as $key => $value) {
                $allErrors[$key] = $value;
            }
        
            \Log::error('Battery Vendor Update Validation Failed', [
                'gst' => $request->gst_number,
                'errors' => $allErrors,
            ]);
        
            return response()->json([
                'success' => false,
                'data' => $allErrors,
                'message' => 'Please check validation error.'
            ], 422);
        }
        
        
    
        try {
            
            
            DB::transaction(function () use ($request, $contact) {
                
                $phoneCode = getPhoneCode();
            
                //\Log::info('Current locale:', ['p' => $phoneCode]);
                
                
                $contact->contact_name    = $request->get('contact_name');
                $contact->company_name    = $request->get('company_name'); 
                $contact->contact_code    = $request->get('contact_code');
                
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->get('phone');
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->get('whatsapp');
                
                $contact->status          = $request->get('status') ?? 'Active';
               
                
                $contact->full_company_name         = $request->get('full_company_name') ?? null;
                $contact->company_owner             = $request->get('company_owner') ?? null;
                $contact->company_registration_no   = $request->get('company_registration_no') ?? null;
                $contact->company_registration_date = $request->get('company_registration_date') ?? null;
                $contact->working_since = $request->get('working_since') ?? null;
                $contact->pan_no = $request->get('pan_no') ?? null;
                $contact->pan_status_id = $request->get('pan_status_id') ?? null;
                //$contact->gst_treatment = 'Registered' ?? null;
                $contact->gst_number = $request->get('gst_number') ?? null;
                $contact->tds_percentage = $request->get('tds_percentage') ?? null;
                $contact->address1 = $request->get('address') ?? null;
                $contact->state_id = $request->get('state_id') ?? null;
                $contact->city_id = $request->get('city_id') ?? null;
                $contact->zipcode = $request->get('post_code') ?? null;
                $contact->additional_info = $request->get('additional_info') ?? null;
                
                if ($request->get('status') === 'Blacklisted') {
                    $contact->blacklisted_at = now();
                }else {
                    $contact->blacklisted_at = null;
                }

                $contact->blacklist_reason = $request->get('blacklist_reason') ?? null;
                $contact->comment          = $request->get('contact_comment');
                
                $contact->updated_by      = Auth::user()->id;
                $contact->save();
    
                // === Update Relcontacts ===
                $relcontact_ids = [];
                foreach ($request->contact_person_name ?? [] as $i => $name) {
                    $rel = Relcontact::find($request->contact_person_id[$i] ?? 0);
                    if (!$rel) {
                        $rel = new Relcontact();
                        $rel->contact_id = $contact->id;
                    }
                    
                    $ph_code = $request->get('contact_person_ph_code')[$i] ?? null;
                    $phone = $request->get('contact_person_phone')[$i] ?? null;
                    
                    $whatsapp_code = $request->get('contact_person_whatsapp_code')[$i] ?? null;
                    $whatsapp = $request->get('contact_person_whatsapp')[$i] ?? null;
                    
                    
                    $rel->name      = $name;
                    $rel->position  = $request->contact_person_designation[$i] ?? null;
                    $rel->ph_prefix = $ph_code ?? $phoneCode;
                    $rel->phone     = $request->contact_person_phone[$i] ?? null;
                    $rel->whatsapp_prefix = $whatsapp_code ?? $phoneCode;
                    $rel->whatsapp      = $request->contact_person_whatsapp[$i] ?? null;
                    $rel->email     = $request->contact_person_email[$i] ?? null;
                    $rel->comment   = $request->contact_person_comment[$i] ?? null;
                    $rel->updated_by = Auth::user()->id;
                    $rel->save();
    
                    $relcontact_ids[] = $rel->id;
                }
    
                Relcontact::where('contact_id', $contact->id)
                          ->whereNotIn('id', $relcontact_ids)
                          ->delete();
                          
                
                // === Update Bank Details ===

                $bankDetailIds = [];
                
                $bankIds          = $request->bank_id ?? [];
                $isPrimaryArr     = $request->is_primary ?? [];
                $beneficiaryNames = $request->beneficiary_name ?? [];
                $accountNumbers   = $request->account_number ?? [];
                $ifscCodes        = $request->ifsc_code ?? [];
                $upiIds           = $request->upi_id ?? [];
                $contactBankIds   = $request->contact_bank_id ?? []; // hidden input for existing bank row id
                
                foreach ($bankIds as $i => $bankId) {
                
                    // Find existing or create new
                    $bank = Contactbank::find($contactBankIds[$i] ?? 0);
                
                    if (!$bank) {
                        $bank = new Contactbank();
                        $bank->contact_id = $contact->id;
                    }
                
                    // If this one is primary → make others No
                    if (($isPrimaryArr[$i] ?? 'No') === 'Yes') {
                        Contactbank::where('contact_id', $contact->id)->update(['is_primary' => 'No']);
                    }
                
                    $bank->bank_id          = $bankId;
                    $bank->is_primary       = ($isPrimaryArr[$i] ?? 'No') === 'Yes' ? 'Yes' : 'No';
                    $bank->beneficiary_name = $beneficiaryNames[$i] ?? null;
                    $bank->account_number   = $accountNumbers[$i] ?? null;
                    $bank->ifsc_code        = $ifscCodes[$i] ?? null;
                    $bank->upi_id           = $upiIds[$i] ?? null;
                    $bank->save();
                
                    $bankDetailIds[] = $bank->id;
                }
                
                // Delete removed bank records
                Contactbank::where('contact_id', $contact->id)
                    ->whereNotIn('id', $bankDetailIds)
                    ->delete();
                
                
                          
                if ($request->filled('blacklist_reason')) {
                    $activity = new Contactactivity();
                    $activity->contact_id = $contact->id;
                    $activity->notes = $request->blacklist_reason; 
                    $activity->is_blacklisted = 'Yes';
                    $activity->created_by = Auth::user()->id;
                    $activity->save();
                }
    
                
                // === TODO: Handle Attachments (if needed) ===
                $attachtypes = $request->attachtypes;
                if(!empty($attachtypes)){
            
                    foreach($attachtypes as $key => $attachtype){
                        
                        if(isset($request->file('files')[$key])){
                            $files = $request->file('files')[$key];
                            
                            foreach($files as $file){
                                $fileoriginalname = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();
                                $filesize = $file->getSize();
                                
                                // Keep original extension
                                $filename = 'contact-attachment-'.Str::random(4).'_'.time().'.'.$extension;

                                $file->move(
                                    public_path('media'.DIRECTORY_SEPARATOR.'contact'.DIRECTORY_SEPARATOR),
                                    $filename
                                );

                                $contact_attachment = new Coattachment;
                                $contact_attachment->name              = $filename;
                                $contact_attachment->original_name     = $fileoriginalname;
                                $contact_attachment->file_size         = ($filesize/(1024 *1024));
                                $contact_attachment->coattachtype_id   = $attachtype;
                                $contact_attachment->created_by        = Auth::id();
                                $contact_attachment->contact_id        = $contact->id;
                                $contact_attachment->save();
                            }
                            
                        }
                    } 
                }
                
                
                // Log activity
                $this->storeUseractivity(69, 4, Auth::user()->id, $contact->id, 'Load Vendor Updated [ID: ' . $contact->id . '].');
                
            });
    
            return response()->json([
                'success' => true,
                'data'    => $contact,
                'message' => 'Battery Vendor updated successfully.'
            ]);
        } catch (\Exception $exp) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage()
            ]);
        }
    }


    // Spare Part Vendor Section ------------------------------------------------------------------------------------------------

    public function spareVendorList(Request $request)
    {
        $cotypeId = self::CONTACT_TYPE_SPARE_VENDOR;

        $search_name = $request->name;
        $search_city = $request->city;

        $contacts = Contact::query()->where('cotype_id', $cotypeId);

        if ($request->filled('name')) {
            $contacts->where('contact_name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('city')) {
            $contacts->where('city_id', $request->city);
        }

        $contacts = $contacts
            ->with(['cotype', 'relcontacts', 'createdby', 'city'])
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        $cotypes = Cotype::all();
        $cotype  = $cotypes->firstWhere('id', self::CONTACT_TYPE_SPARE_VENDOR);

        $cities = City::whereHas('state.country', function ($q) {
                            $q->where('iso2', 'IN');
                        })->orderBy('name')->get();

        return view('contacts.sparevendor.index', compact('contacts', 'cities', 'cotype', 'search_name', 'search_city'));
    }

    public function createSpareVendor(Request $request)
    {
        $organisation_id = optional(Auth::user()->organisation)->id;

        $countries = Country::all();
        $states    = State::whereHas('country', fn($q) => $q->where('iso2', 'IN'))
                        ->orderBy('name')->get();

        $cotypes           = Cotype::all();
        $customerabouttype = Customerabouttype::orderBy('name')->get();
        $gsttreats         = Gsttreat::all();
        $coattachtypes     = Coattachtype::all();
        $cotype            = $cotypes->firstWhere('id', self::CONTACT_TYPE_SPARE_VENDOR);
        $pan_statuses      = Panstatus::where('organisation_id', $organisation_id)->orderBy('name')->get();
        $banks             = Bank::orderBy('name')->get();
        $spareCategories   = WsSparePartCategory::active()->orderBy('name')->get();

        return view('contacts.sparevendor.create',
            compact('customerabouttype', 'countries', 'states', 'cotype', 'cotypes',
                    'gsttreats', 'coattachtypes', 'pan_statuses', 'banks', 'spareCategories'));
    }

    public function storeSpareVendor(Request $request)
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
            'gst_number'                  => 'nullable|max:100',
            'company_name'                => 'required|max:100',
            'contact_name'                => 'required|max:100',
            'contact_code'                => 'required|max:100',
            'phone'                       => ['required', 'digits:10', $validate_phone],
            'whatsapp'                    => ['nullable', 'digits:10'],
            'status'                      => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'            => 'required_if:status,Blacklisted',
            'contact_comment'             => 'nullable|string|max:255',
            'full_company_name'           => 'nullable|max:100',
            'company_owner'               => 'nullable|max:100',
            'company_registration_no'     => 'nullable|max:100',
            'company_registration_date'   => 'nullable|date|before_or_equal:today',
            'working_since'               => 'nullable|date|before_or_equal:today',
            'pan_no'                      => 'nullable|max:100',
            'pan_status_id'               => 'nullable|integer|exists:panstatuses,id',
            'tds_percentage'              => 'nullable|numeric|min:0|max:100',
            'address'                     => 'required|string|max:1000',
            'state_id'                    => 'required|exists:states,id',
            'city_id'                     => 'required|exists:cities,id',
            'post_code'                   => 'nullable|digits:6',
            'additional_info'             => 'nullable|string|max:10000',
            'is_primary'                  => 'required|array',
            'is_primary.*'                => 'required|in:Yes,No',
            'bank_id'                     => 'required|array',
            'bank_id.*'                   => 'required|exists:banks,id',
            'beneficiary_name'            => 'nullable|array',
            'beneficiary_name.*'          => 'nullable|string|max:255',
            'account_number'              => 'required|array',
            'account_number.*'            => 'required|string|max:50',
            'ifsc_code'                   => 'required|array',
            'ifsc_code.*'                 => 'required|string|max:20',
            'upi_id'                      => 'nullable|array',
            'upi_id.*'                    => 'nullable|string|max:100',
            'contact_person_name'         => 'required|array|min:1',
            'contact_person_name.*'       => 'required|string|distinct|min:1',
            'contact_person_designation'  => 'required|array|min:1',
            'contact_person_designation.*'=> 'required|string|min:1',
            'contact_person_phone'        => 'required|array|min:1',
            'contact_person_phone.*'      => ['required', 'string', 'distinct', $validate_cp_phone],
            'contact_person_email'        => 'nullable|array|min:1',
            'contact_person_email.*'      => 'nullable|email:rfc,dns|distinct',
            'attachtypes'                 => 'nullable|array',
            'attachtypes.*'               => 'nullable|exists:coattachtypes,id',
            'files'                       => 'nullable|array',
            'files.*'                     => 'nullable|array|max:2',
            'files.*.*'                   => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'required'    => 'This field is required.',
            'max'         => 'Maximum 100 characters allowed.',
            'exists'      => "This field's value is invalid.",
            'distinct'    => 'Duplicate value.',
            'email'       => 'This email is invalid.',
            'phone.digits'=> 'Must be 10 digits.',
        ]);

        $validator->after(function ($validator) use ($request) {
            $isPrimaryArr = $request->is_primary ?? [];
            $primaryCount = collect($isPrimaryArr)->filter(fn($v) => $v === 'Yes')->count();
            if ($primaryCount === 0) $validator->errors()->add('is_primary', 'At least one bank must be Primary.');
            if ($primaryCount > 1)  $validator->errors()->add('is_primary', 'Only one bank can be Primary.');
        });

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors()->toArray(), 'message' => 'Validation error.'], 422);
        }

        try {
            $contact = null;

            DB::transaction(function () use ($request, &$contact) {
                $last = Contact::withTrashed()->orderBy('id', 'DESC')->first();
                $n    = $last ? (int)$last->contactno + 1 : 1;
                $contactno = str_pad($n, 6, '0', STR_PAD_LEFT);

                $phoneCode = getPhoneCode();

                $contact = new Contact;
                $contact->contactno       = $contactno;
                $contact->cotype_id       = self::CONTACT_TYPE_SPARE_VENDOR;
                $contact->organisation_id = optional(Auth::user()?->organisation)->id;
                $contact->contact_name    = $request->contact_name;
                $contact->company_name    = $request->company_name;
                $contact->contact_code    = $request->contact_code;
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->phone;
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->whatsapp;
                $contact->status          = $request->status ?? 'Active';
                $contact->blacklist_reason= $request->blacklist_reason;
                $contact->comment         = $request->contact_comment;   // contacts.comment
                $contact->specialisation  = $request->specialisation ? implode(',', (array)$request->specialisation) : null;
                $contact->full_company_name = $request->full_company_name;
                $contact->company_owner   = $request->company_owner;
                $contact->company_registration_no   = $request->company_registration_no;
                $contact->company_registration_date = $request->company_registration_date;
                $contact->working_since   = $request->working_since;
                $contact->pan_no          = $request->pan_no;
                $contact->pan_status_id   = $request->pan_status_id;
                $contact->tds_percentage  = $request->tds_percentage;
                $contact->address1        = $request->address;           // contacts.address1
                $contact->state_id        = $request->state_id;
                $contact->city_id         = $request->city_id;
                $contact->zipcode         = $request->post_code;         // contacts.zipcode
                $contact->additional_info = $request->additional_info;
                $contact->created_by      = Auth::id();
                $contact->save();

                // Contact persons — stored in relcontacts table
                $names        = $request->contact_person_name         ?? [];
                $designations = $request->contact_person_designation  ?? [];
                $phCodes      = $request->contact_person_ph_code      ?? [];
                $whatsappCodes= $request->contact_person_whatsapp_code ?? [];
                $whatsapps    = $request->contact_person_whatsapp     ?? [];
                $phones       = $request->contact_person_phone        ?? [];
                $emails       = $request->contact_person_email        ?? [];
                $comments     = $request->contact_person_comment      ?? [];

                foreach ($names as $idx => $name) {
                    if (!$name) continue;
                    $cp = new \App\Models\Relcontact;
                    $cp->contact_id      = $contact->id;
                    $cp->name            = $name;                          // relcontacts.name
                    $cp->position        = $designations[$idx] ?? null;   // relcontacts.position
                    $cp->ph_prefix       = $phCodes[$idx] ?? $phoneCode;
                    $cp->phone           = $phones[$idx] ?? null;
                    $cp->whatsapp_prefix = $whatsappCodes[$idx] ?? $phoneCode;
                    $cp->whatsapp        = $whatsapps[$idx] ?? null;
                    $cp->email           = $emails[$idx] ?? null;
                    $cp->comment         = $comments[$idx] ?? null;
                    $cp->created_by      = Auth::id();
                    $cp->save();
                }

                // Bank details
                $bankIds   = $request->bank_id        ?? [];
                $benefNames= $request->beneficiary_name ?? [];
                $accNos    = $request->account_number  ?? [];
                $ifscCodes = $request->ifsc_code       ?? [];
                $upiIds    = $request->upi_id          ?? [];
                $isPrimary = $request->is_primary      ?? [];

                foreach ($bankIds as $idx => $bankId) {
                    if (!$bankId) continue;
                    \App\Models\Contactbank::create([
                        'contact_id'       => $contact->id,
                        'bank_id'          => $bankId,
                        'beneficiary_name' => $benefNames[$idx] ?? null,
                        'account_number'   => $accNos[$idx]     ?? null,
                        'ifsc_code'        => $ifscCodes[$idx]  ?? null,
                        'upi_id'           => $upiIds[$idx]     ?? null,
                        'is_primary'       => $isPrimary[$idx]  ?? 'No',
                    ]);
                }
            });

            return response()->json([
                'success'  => true,
                'message'  => 'Spare vendor added successfully.',
                'redirect' => route('contact.sparevendor.index'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function editSpareVendor(Request $request, $id)
    {
        $contact = Contact::with([
                'country.states', 'state.cities', 'relcontacts',
                'bankDetails', 'coattachments.coattachtype',
                'activities', 'activities.createdBy',
            ])
            ->where('cotype_id', self::CONTACT_TYPE_SPARE_VENDOR)
            ->findOrFail($id);

        $organisation_id = optional(Auth::user()->organisation)->id;

        $countries         = Country::all();
        $states            = State::whereHas('country', fn($q) => $q->where('iso2', 'IN'))->orderBy('name')->get();
        $cotypes           = Cotype::all();
        $customerabouttype = Customerabouttype::orderBy('name')->get();
        $gsttreats         = Gsttreat::all();
        $coattachtypes     = Coattachtype::all();
        $cotype            = $cotypes->firstWhere('id', self::CONTACT_TYPE_SPARE_VENDOR);
        $pan_statuses      = Panstatus::where('organisation_id', $organisation_id)->orderBy('name')->get();
        $banks             = Bank::orderBy('name')->get();
        $spareCategories   = WsSparePartCategory::active()->orderBy('name')->get();

        $description  = 'Retrieve spare vendor ' . $contact->contact_name . ' to edit.';
        $this->storeUseractivity(69, 5, Auth::user()->id, $contact->id, $description);

        return view('contacts.sparevendor.edit',
            compact('contact', 'customerabouttype', 'countries', 'states', 'cotype', 'cotypes',
                    'gsttreats', 'coattachtypes', 'pan_statuses', 'banks', 'spareCategories'));
    }

    public function updateSpareVendor(Request $request, $id)
    {
        $request->merge([
            'phone'    => preg_replace('/\s+/', '', $request->phone    ?? ''),
            'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp ?? ''),
        ]);

        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_SPARE_VENDOR)->findOrFail($id);

        $validate_phone = function (string $attribute, mixed $value, Closure $fail) use ($id) {
            $code = getPhoneCode();
            if (Contact::where('phone', $value)->where('ph_prefix', $code)->where('id', '!=', $id)->exists()) {
                $fail('This phone number already exists.');
            }
        };

        $validator = Validator::make($request->all(), [
            'gst_number'                  => 'nullable|max:100',
            'company_name'                => 'required|max:100',
            'contact_name'                => 'required|max:100',
            'contact_code'                => 'required|max:100',
            'phone'                       => ['required', 'digits:10', $validate_phone],
            'whatsapp'                    => ['nullable', 'digits:10'],
            'status'                      => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'            => 'required_if:status,Blacklisted',
            'contact_comment'             => 'nullable|string|max:255',
            'full_company_name'           => 'nullable|max:100',
            'company_owner'               => 'nullable|max:100',
            'company_registration_no'     => 'nullable|max:100',
            'company_registration_date'   => 'nullable|date|before_or_equal:today',
            'working_since'               => 'nullable|date|before_or_equal:today',
            'pan_no'                      => 'nullable|max:100',
            'pan_status_id'               => 'nullable|integer|exists:panstatuses,id',
            'tds_percentage'              => 'nullable|numeric|min:0|max:100',
            'address'                     => 'required|string|max:1000',
            'state_id'                    => 'required|exists:states,id',
            'city_id'                     => 'required|exists:cities,id',
            'post_code'                   => 'nullable|digits:6',
            'additional_info'             => 'nullable|string|max:10000',
            'is_primary'                  => 'required|array',
            'is_primary.*'                => 'required|in:Yes,No',
            'bank_id'                     => 'required|array',
            'bank_id.*'                   => 'required|exists:banks,id',
            'account_number'              => 'required|array',
            'account_number.*'            => 'required|string|max:50',
            'ifsc_code'                   => 'required|array',
            'ifsc_code.*'                 => 'required|string|max:20',
            'upi_id'                      => 'nullable|array',
            'upi_id.*'                    => 'nullable|string|max:100',
            'contact_person_name'         => 'required|array|min:1',
            'contact_person_name.*'       => 'required|string|distinct|min:1',
            'contact_person_designation'  => 'required|array|min:1',
            'contact_person_designation.*'=> 'required|string|min:1',
            'contact_person_phone'        => 'required|array|min:1',
            'contact_person_phone.*'      => ['required', 'string', 'distinct'],
            'contact_person_email'        => 'nullable|array|min:1',
            'contact_person_email.*'      => 'nullable|email:rfc,dns|distinct',
        ], [
            'required' => 'This field is required.',
            'max'      => 'Maximum 100 characters allowed.',
            'exists'   => "This field's value is invalid.",
            'distinct' => 'Duplicate value.',
            'email'    => 'This email is invalid.',
        ]);

        $validator->after(function ($validator) use ($request) {
            $isPrimaryArr = $request->is_primary ?? [];
            $primaryCount = collect($isPrimaryArr)->filter(fn($v) => $v === 'Yes')->count();
            if ($primaryCount === 0) $validator->errors()->add('is_primary', 'At least one bank must be Primary.');
            if ($primaryCount > 1)  $validator->errors()->add('is_primary', 'Only one bank can be Primary.');
        });

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors()->toArray(), 'message' => 'Validation error.'], 422);
        }

        try {
            DB::transaction(function () use ($request, $contact) {
                $phoneCode = getPhoneCode();

                $contact->contact_name    = $request->contact_name;
                $contact->company_name    = $request->company_name;
                $contact->contact_code    = $request->contact_code;
                $contact->ph_prefix       = $request->phone_code ?? $phoneCode;
                $contact->phone           = $request->phone;
                $contact->whatsapp_prefix = $request->whatsapp_code ?? $phoneCode;
                $contact->whatsapp        = $request->whatsapp;
                $contact->status          = $request->status ?? 'Active';
                $contact->blacklist_reason= $request->blacklist_reason;
                $contact->comment         = $request->contact_comment;
                $contact->specialisation  = $request->specialisation ? implode(',', (array)$request->specialisation) : null;
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

                // Sync contact persons — stored in relcontacts table
                $existingIds  = $request->contact_person_id      ?? [];
                $names        = $request->contact_person_name        ?? [];
                $desigs       = $request->contact_person_designation ?? [];
                $phCodes      = $request->contact_person_ph_code     ?? [];
                $whatsappCodes= $request->contact_person_whatsapp_code ?? [];
                $whatsapps    = $request->contact_person_whatsapp   ?? [];
                $phones       = $request->contact_person_phone       ?? [];
                $emails       = $request->contact_person_email       ?? [];
                $comments     = $request->contact_person_comment     ?? [];

                $submittedIds = [];
                foreach ($names as $idx => $name) {
                    if (!$name) continue;
                    $personId = $existingIds[$idx] ?? null;
                    if ($personId) {
                        $cp = \App\Models\Relcontact::find($personId);
                        if (!$cp) continue;
                        $submittedIds[] = (int) $personId;
                    } else {
                        $cp = new \App\Models\Relcontact;
                        $cp->contact_id  = $contact->id;
                        $cp->created_by  = Auth::id();
                    }
                    $cp->name            = $name;                          // relcontacts.name
                    $cp->position        = $desigs[$idx]          ?? null; // relcontacts.position
                    $cp->ph_prefix       = $phCodes[$idx]         ?? $phoneCode;
                    $cp->phone           = $phones[$idx]           ?? null;
                    $cp->whatsapp_prefix = $whatsappCodes[$idx]   ?? $phoneCode;
                    $cp->whatsapp        = $whatsapps[$idx]        ?? null;
                    $cp->email           = $emails[$idx]           ?? null;
                    $cp->comment         = $comments[$idx]         ?? null;
                    $cp->updated_by      = Auth::id();
                    $cp->save();
                }
                // Soft-delete removed persons
                \App\Models\Relcontact::where('contact_id', $contact->id)
                    ->whereNotIn('id', $submittedIds)
                    ->delete();

                // Sync bank details — delete all and re-insert
                \App\Models\Contactbank::where('contact_id', $contact->id)->delete();
                $bankIds    = $request->bank_id        ?? [];
                $benefNames = $request->beneficiary_name ?? [];
                $accNos     = $request->account_number  ?? [];
                $ifscCodes  = $request->ifsc_code       ?? [];
                $upiIds     = $request->upi_id          ?? [];
                $isPrimary  = $request->is_primary      ?? [];
                foreach ($bankIds as $idx => $bankId) {
                    if (!$bankId) continue;
                    \App\Models\Contactbank::create([
                        'contact_id'       => $contact->id,
                        'bank_id'          => $bankId,
                        'beneficiary_name' => $benefNames[$idx] ?? null,
                        'account_number'   => $accNos[$idx]     ?? null,
                        'ifsc_code'        => $ifscCodes[$idx]  ?? null,
                        'upi_id'           => $upiIds[$idx]     ?? null,
                        'is_primary'       => $isPrimary[$idx]  ?? 'No',
                    ]);
                }
            });

            return response()->json([
                'success'  => true,
                'message'  => 'Spare vendor updated successfully.',
                'redirect' => route('contact.sparevendor.index'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function toggleSpareVendorStatus(Request $request, $id)
    {
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_SPARE_VENDOR)->findOrFail($id);
        $contact->status     = $contact->status === 'Active' ? 'Inactive' : 'Active';
        $contact->updated_by = Auth::id();
        $contact->save();

        return response()->json([
            'success'    => true,
            'new_status' => $contact->status,
            'message'    => 'Status updated to ' . $contact->status . '.',
        ]);
    }

    public function destroySpareVendor($id)
    {
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_SPARE_VENDOR)->findOrFail($id);
        $contact->deleted_by = Auth::id();
        $contact->save();
        $contact->delete(); // SoftDeletes

        return response()->json(['success' => true, 'message' => 'Vendor deleted.']);
    }

    public function sparevendor_contactPersonWrapper(Request $request){
        $rowindex = $request->rowindex ?? 0;
        $html = view('contacts.contact-person-wrapper.sparevendor-contact-person', compact('rowindex'))->render();
        return response()->json(['html' => $html]);
    }

    public function sparevendor_bankWrapper(Request $request){
        $rowindex = $request->rowindex ?? 0;
        $banks = Bank::orderBy('name')->get();
        $html = view('contacts.contact-bank-detail-wrapper.sparevendor-bank-detail', compact('rowindex','banks'))->render();
        return response()->json(['html' => $html]);
    }


    // ─── Insurance Providers ────────────────────────────────────────────────────

    public function insuranceProviderList(Request $request): View
    {
        $cotypeId    = self::CONTACT_TYPE_INSURANCE_PROVIDER;
        $search_name = $request->name;
        $search_city = $request->city;

        $contacts = Contact::query()->where('cotype_id', $cotypeId);

        if ($request->filled('name')) {
            $contacts->where('contact_name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('city')) {
            $contacts->where('city_id', $request->city);
        }

        $contacts = $contacts
            ->with(['cotype', 'relcontacts'])
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        $cotypes = Cotype::all();
        $cotype  = $cotypes->firstWhere('id', self::CONTACT_TYPE_INSURANCE_PROVIDER)
                   ?? (object)['id' => self::CONTACT_TYPE_INSURANCE_PROVIDER, 'name' => 'Insurance Provider'];

        $cities  = City::whereHas('state.country', fn($q) => $q->where('iso2', 'IN'))
                       ->orderBy('name')->get();
        $states  = State::whereHas('country', fn($q) => $q->where('iso2', 'IN'))
                        ->orderBy('name')->get();

        return view('contacts.insuranceprovider.index',
            compact('contacts', 'cities', 'states', 'cotype', 'search_name', 'search_city'));
    }

    /** GET /contacts/insurance-provider/{id}/json — used by edit modal */
    public function getInsuranceProvider(int $id)
    {
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_INSURANCE_PROVIDER)->findOrFail($id);
        return response()->json(['success' => true, 'contact' => $contact]);
    }

    public function storeInsuranceProvider(Request $request)
    {
        $request->merge([
            'phone'    => preg_replace('/\s+/', '', $request->phone),
            'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp ?? ''),
        ]);

        $validate_phone = function ($attribute, $value, $fail) use ($request) {
            $code = $request->phone_code ?? getPhoneCode();
            if (Contact::where('phone', $value)->where('ph_prefix', $code)->exists()) {
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
            'contact_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors()], 422);
        }

        $contact = NULL;
        try{
            DB::transaction(function() use ($request, &$contact){
                $lastcontact = Contact::withTrashed()->orderBy('id', 'DESC')->first();
                if($lastcontact){
                    $lastcontactno = $lastcontact->contactno;
                    $incr_lastcontact = $lastcontactno+1;
                    if(strlen($incr_lastcontact)<5){
                        $contactno = '0';
                        for($i = 0; $i<(5-strlen($incr_lastcontact)); $i++){
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

                $cotype = Cotype::where('slug', 'insuranceprovider')->first();

                $contact = new Contact();
                $contact->contactno      = $contactno;
                $contact->cotype_id      = self::CONTACT_TYPE_INSURANCE_PROVIDER;
                $contact->company_name   = $request->company_name;
                $contact->contact_name   = $request->contact_name;
                $contact->contact_code   = $request->contact_code;
                $contact->phone          = $request->phone;
                $contact->ph_prefix      = $request->phone_code ?? getPhoneCode();
                $contact->whatsapp       = $request->whatsapp;
                $contact->email          = $request->email;
                $contact->address1       = $request->address;
                $contact->country_id     = $request->country_id;
                $contact->state_id       = $request->state_id;
                $contact->city_id        = $request->city_id;
                $contact->zipcode        = $request->pincode;
                $contact->gst_number     = $request->gst_number;
                $contact->pan_no         = $request->pan_number;
                $contact->tds_percentage = $request->tds_percentage ?? 0;
                $contact->status         = $request->status ?? 'Active';
                $contact->comment = $request->contact_comment;
                $contact->created_by     = Auth::id();

                if ($request->hasFile('contact_image') && $request->file('contact_image')->isValid()) {
                    $uploadPath = public_path('media/contact');
                    if (!\File::exists($uploadPath)) { \File::makeDirectory($uploadPath, 0755, true); }
                    $filename = 'ip_' . time() . '_' . uniqid() . '.' . $request->file('contact_image')->getClientOriginalExtension();
                    $request->file('contact_image')->move($uploadPath, $filename);
                    $contact->contact_image = $filename;
                }

                $contact->save();
            });
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 422);
        }
        

        return response()->json([
            'success' => true,
            'message' => $contact->company_name . ' added successfully.',
        ]);
    }

    public function updateInsuranceProvider(Request $request, $id)
    {
        $request->merge([
            'phone'    => preg_replace('/\s+/', '', $request->phone    ?? ''),
            'whatsapp' => preg_replace('/\s+/', '', $request->whatsapp ?? ''),
        ]);

        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_INSURANCE_PROVIDER)->findOrFail($id);

        $validate_phone = function (string $attribute, mixed $value, Closure $fail) use ($id) {
            $code = getPhoneCode();
            if (Contact::where('phone', $value)->where('ph_prefix', $code)->where('id', '!=', $id)->exists()) {
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
            'contact_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors()], 422);
        }

        $contact->company_name    = $request->company_name;
        $contact->contact_name    = $request->contact_name;
        $contact->contact_code    = $request->contact_code;
        $contact->phone           = $request->phone;
        $contact->ph_prefix       = $request->phone_code ?? getPhoneCode();
        $contact->whatsapp        = $request->whatsapp;
        $contact->email           = $request->email;
        // $contact->address         = $request->address;
        $contact->country_id      = $request->country_id;
        $contact->state_id        = $request->state_id;
        $contact->city_id         = $request->city_id;
        $contact->zipcode         = $request->pincode;
        $contact->gst_number      = $request->gst_number;
        $contact->pan_no          = $request->pan_number;
        $contact->tds_percentage  = $request->tds_percentage ?? 0;
        $contact->status          = $request->status ?? 'Active';
        $contact->comment = $request->contact_comment;
        $contact->updated_by      = Auth::id();

        if ($request->hasFile('contact_image') && $request->file('contact_image')->isValid()) {
            // Delete old image
            if ($contact->contact_image) {
                $old = public_path('media/contact/' . $contact->contact_image);
                if (\File::exists($old)) { \File::delete($old); }
            }
            $uploadPath = public_path('media/contact');
            if (!\File::exists($uploadPath)) { \File::makeDirectory($uploadPath, 0755, true); }
            $filename = 'ip_' . time() . '_' . uniqid() . '.' . $request->file('contact_image')->getClientOriginalExtension();
            $request->file('contact_image')->move($uploadPath, $filename);
            $contact->contact_image = $filename;
        }

        $contact->save();

        return response()->json([
            'success' => true,
            'message' => $contact->company_name . ' updated successfully.',
        ]);
    }

    public function toggleInsuranceProviderStatus(Request $request, $id)
    {
        $contact   = Contact::where('cotype_id', self::CONTACT_TYPE_INSURANCE_PROVIDER)->findOrFail($id);
        $newStatus = $contact->status === 'Active' ? 'Inactive' : 'Active';
        $contact->update(['status' => $newStatus, 'updated_by' => Auth::id()]);

        return response()->json([
            'success'    => true,
            'new_status' => $newStatus,
            'message'    => $contact->company_name . ' marked as ' . $newStatus . '.',
        ]);
    }

    public function destroyInsuranceProvider($id)
    {
        $contact = Contact::where('cotype_id', self::CONTACT_TYPE_INSURANCE_PROVIDER)->findOrFail($id);
        $contact->update(['deleted_by' => Auth::id()]);
        $contact->delete();

        return response()->json([
            'success' => true,
            'message' => $contact->company_name . ' removed.',
        ]);
    }

    // Other Section ---------------------------------------------------------------------------------------------------------
    
    
    
    
    
    
    
    
    
    
    
    
}






















