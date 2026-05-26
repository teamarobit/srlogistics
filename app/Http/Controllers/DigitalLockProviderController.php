<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;

use App\Models\Digitallockprovider;


use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Auth;

use App\Traits\Useractivity;


class DigitalLockProviderController extends Controller
{

    use Useractivity;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $search_name   = $request->get('name');
        $search_status = $request->get('status');

        // Sort — same pattern as GpsProviderController
        $sort_by  = in_array($request->get('sort_by'), ['name','code','status','created_at','updated_at']) ? $request->get('sort_by') : 'created_at';
        $sort_dir = $request->get('sort_dir') === 'asc' ? 'asc' : 'desc';

        $datas = Digitallockprovider::with(['createdBy','updatedBy'])
                                ->when(!empty($search_name), function ($query) use ($search_name) {
                                    // Escape LIKE wildcards so '%' and '_' inside the search term are treated literally.
                                    $term = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], trim($search_name));
                                    $query->where('name', 'like', '%' . $term . '%');
                                })
                                ->when(!is_null($search_status) && $search_status !== '', function ($query) use ($search_status) {
                                    $query->where('status', $search_status);
                                })
                                ->orderBy($sort_by, $sort_dir)
                                ->paginate(10)
                                ->withQueryString();

        return view('provider.digilock.index', compact(
            'datas','search_name','search_status','sort_by','sort_dir'
        ));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('provider.digilock.create');
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
            'provider_name' => 'required|max:100|unique:digitallockproviders,name',
            'status'          => 'required|in:Active,Inactive',

        ], [
                'required' => 'This field is required.',
                'max'      => 'Maximum 100 characters allowed.',
                'unique'   => 'This value already exists.',
                'numeric'  => 'Only numeric values are allowed.',
                'min'      => 'Value must be at least :min.',
                'max'      => 'Maximum allowed value is :max.',
                'in'       => 'Invalid selection.',
            ]
        );

        $errorcount = 0;
        $errors = [];

        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);

        if($validator->fails() || $errorcount > 0){
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }

        try{

            $provider = [];

            $provider = DB::transaction(function () use($request){

                $lastCode = Digitallockprovider::withTrashed()->orderBy('id', 'DESC')->first();
                $provider_code = $lastCode ? str_pad((int) $lastCode->code + 1, 6, '0', STR_PAD_LEFT) : '000001';


                $provider = new Digitallockprovider;
                $provider->name = $request->provider_name;
                $provider->code = $provider_code;
                $provider->status = $request->status;
                $provider->created_by = Auth::user()->id;
                $provider->save();

                $description = 'Added new digital lock provider.';
                $this->storeUseractivity(56, 3, Auth::user()->id, $provider->id, $description);

                return $provider;
            });

            return response()->json([
                'success' => true,
                'data'    => $provider,
                'message' => 'Digital Lock provider saved successfully.'
            ], 200);

        } catch (\Exception $exp){
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show(Request $request)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // BUG-003: never return raw JSON from a GET view route.
        // Redirect back to listing with a flash error if record is missing.
        if(empty($id)){
            return redirect()->route('digilockprovider.index')
                             ->with('error', 'Woops! id not found.');
        }

        $record = Digitallockprovider::find($id);

        if($record == NULL){
            return redirect()->route('digilockprovider.index')
                             ->with('error', 'Woops! Data not found.');
        }


        // Log activity
        $description = 'Retrieve a record named '.$record->name.' to edit.';
        $this->storeUseractivity(56, 5, Auth::user()->id, $record->id, $description);

        return view('provider.digilock.edit', compact('record'));
    }





    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'provider_name' => [
                'required',
                'max:100',
                Rule::unique('digitallockproviders', 'name')->ignore($request->get('recordid'), 'id'),
            ],
            'status'          => 'required|in:Active,Inactive',

        ], [
                'required' => 'This field is required.',
                'max'      => 'Maximum 100 characters allowed.',
                'unique'   => 'This value already exists.',
                'numeric'  => 'Only numeric values are allowed.',
                'min'      => 'Value must be at least :min.',
                'max'      => 'Maximum allowed value is :max.',
                'in'       => 'Invalid selection.',
            ]
        );

        $errorcount = 0;
        $errors = [];

        // SD-8 — find() not findOrFail() in AJAX
        $record = Digitallockprovider::find($request->get('recordid'));

        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Data not found.'], 422);
        }


        $errormessages = array_merge($validator->getMessageBag()->toArray(), $errors);

        if($validator->fails() || $errorcount > 0){
            return response()->json(['success' => false, 'data' => $errormessages, 'message' => 'Please check validation error.'], 422);
        }

        try{
            $record = DB::transaction(function () use($request, $record){

                $record->name = $request->get('provider_name');
                $record->status = $request->get('status');

                $record->updated_by = Auth::user()->id;
                $record->save();

                $description = 'Updated a digital lock provider.';
                $this->storeUseractivity(56, 4, Auth::user()->id, $record->id, $description);

                return $record;
            });

            return response()->json([
                'success' => true,
                'data'    => $record,
                'message' => 'Digital Lock provider updated successfully.'
            ], 200);

        } catch (\Exception $exp){
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage()
            ], 500);
        }
    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->get('recordid');

        if (empty($id)) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Woops! ID not found.'
            ], 422);
        }

        // SD-8 — find() not findOrFail() in AJAX
        $record = Digitallockprovider::find($id);

        if (!$record) {
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => 'Woops! Digital Lock provider not found.'
            ], 422);
        }

        try{
            DB::transaction(function () use($id, $record){
                $record->deleted_by = Auth::user()->id;
                $record->save();

                $record->delete(); // soft delete

                // Log activity
                $description = 'Deleted a digital lock provider.';
                $this->storeUseractivity(56, 6, Auth::user()->id, $id, $description);
            });

            return response()->json([
                'success' => true,
                'data'    => [],
                'message' => 'Digital Lock provider deleted successfully.'
            ], 200);

        } catch (\Exception $exp){
            return response()->json([
                'success' => false,
                'data'    => [],
                'message' => $exp->getMessage()
            ], 500);
        }
    }





}
