<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Country;
use App\Models\State;


use Spatie\Permission\Models\Role;
use DB;
use Hash;
use File;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        $organisation = auth()->user()->organisation;
        $orgName = optional(auth()->user()->organisation)->name;
        //dd($organisation);
        
        return view('admin.index',compact('orgName'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $countries = Country::all();
        $states = State::all();
        $millcolors = MillColor::all();
        return view('mills.create',compact('states', 'countries','millcolors'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'mill_name'         => 'required|max:100',
            'mill_short_name'   => 'required|max:100',
            'mill_address'      => 'required',
            'postal_code'       => 'required',
            'mill_state'        => 'required|exists:states,id',
            'mill_city'         => [
                  'required',
                   Rule::exists('cities', 'id')->where(function ($query) use ( $request ){
                         $query->where('state_id', $request->get('mill_state'));
                   }),
             ],
            'mill_ph_prefix'    => 'required|required_with:mill_phone|regex:/^\+\d{1,4}$/',
            'mill_phone'        => 'required|required_with:mill_ph_prefix|digits:10',
            'mill_email'        => 'required|email|unique:mills,email',
            'logo'              => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'signature'         => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'mill_color'        => 'sometimes|exists:millcolors,id'
            
        ], [
                'required'            => 'This field is required.',
                'mill_name.max'       => 'Maximum 100 characters allowed.',
                'exists'              => "This field's value is invalid.",
                
            ]
        );
        
        $errorcount = 0;
        $errors = [];
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
        
        $logo = NULL;
        if($request->hasFile('logo')){
            $file = $request->file('logo');
            $fileoriginalname = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $logo = 'logo'.'_'.time() . '.webp';
            $file->move(public_path('media'.DIRECTORY_SEPARATOR.'mill'.DIRECTORY_SEPARATOR.'logo'.DIRECTORY_SEPARATOR), $logo);
        }
        
        $signature = NULL;
        if($request->hasFile('signature')){
            $file = $request->file('signature');
            $fileoriginalname = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $signature = 'signature'.'_'.time() . '.webp';
            $file->move(public_path('media'.DIRECTORY_SEPARATOR.'mill'.DIRECTORY_SEPARATOR.'signature'.DIRECTORY_SEPARATOR), $signature);
        }
        $mill = new Mill;
        $mill->name        = $request->get('mill_name');
        $mill->short_name  = $request->get('mill_short_name');
        $mill->state_id    = $request->get('mill_state');
        $mill->city_id     = $request->get('mill_city');
        $mill->address     = $request->get('mill_address');
        $mill->postalcode     = $request->get('postal_code');
        
        if($request->has('mill_phone') && $request->has('mill_ph_prefix')){
           $mill->phone           = $request->get('mill_phone');
           $mill->ph_prefix       = $request->get('mill_ph_prefix');
        }
        
        if($request->has('mill_email')){
           $mill->email           = $request->get('mill_email');
        }
        
        
        $mill->millcolor_id    = $request->get('mill_color');
        
        
        if($logo){  
            $mill->logo = $logo;
        }
        
        if($signature){
            $mill->signature = $signature;
        }
        $mill->trade_name = '';
        $mill->save();
        
        $redirectto = route('mill.edit', $mill->id);
        
        return response()->json(['success' => true, 'data' => ['mill' =>$mill, 'redirectto' => $redirectto], 'message' => 'Mill saved successfully.']);
    }
    
    public function storeTaxSetting(Request $request, $id)
    {
        
        $mill = Mill::find($id);
        if($mill == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Mill not found.'], 422);
        }
        
        $validator = Validator::make($request->all(), [
            'gstin'                     => 'nullable|digits:15',
            'gst_registration_date'     => 'nullable|date_format:d-m-Y',
            'pan'                       => 'nullable|max:100',
            'tan'                       => 'nullable|max:100',
            'cin'                       => 'nullable|max:100',
            'tds_no'                    => 'nullable|max:100',
            'legal_name'                => 'nullable|nax:100',
            'trade_name'                => 'nullable|max:100'
            
        ], [
                'required'              => 'This field is required.',
                'max'                   => 'Maximum 100 characters allowed.',
                'exists'                => "This field's value is invalid.",
                
            ]
        );
        
        $errorcount = 0;
        $errors = [];
        
        $gst_registered = $request->get('gst_registered');
        $gstin = $request->get('gstin');
        $gst_registration_date = $request->get('gst_registration_date');
        
        if($gst_registered){
            
            if($gstin == ''){
                $errors['gstin'] = 'This field is required.';
                $errorcount++;
            }
            
            
            if($gst_registration_date == ''){
                $errors['gst_registration_date'] = 'This field is required.';
                $errorcount++;
            }
        }
        
        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);
        
        if($validator->fails() || $errorcount > 0){
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }
        
    
        $mill->gst_registered           = $gst_registered == '' ? 'No' : 'Yes';
        $mill->gst_registered_on        = $gst_registration_date != '' ? date('Y-m-d', strtotime($gst_registration_date)) : NULL;
        $mill->pan                      = $request->get('pan');
        $mill->tan                      = $request->get('tan');
        $mill->cin                      = $request->get('cin');
        $mill->tdsno                    = $request->get('tds_no');
        $mill->legal_name               = $request->get('legal_name');
        $mill->trade_name               = $request->get('trade_name');
        $mill->update();
        
        $redirectto = route('mill.edit', $mill->id);
        
        return response()->json(['success' => true, 'data' => ['mill' =>$mill, 'redirectto' => $redirectto], 'message' => 'Tax settings saved successfully.']);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $user = User::find($id);

        return view('users.show',compact('user'));
    }
    
    
}