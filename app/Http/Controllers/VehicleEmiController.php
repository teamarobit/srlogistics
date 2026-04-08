<?php
  
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Loanaccount;
use App\Models\Loanaccountlog;
use App\Models\Loanaccountcrongivenemi;
use App\Models\Emipaymentrecordnote;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

use Auth;
use Closure;
use Illuminate\View\View;
use Illuminate\Support\Str;

use App\Traits\Useractivity;


class VehicleEmiController extends Controller
{
    use Useractivity;
    
    
    public function storeEmi(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'finance_provider_id' => 'required|exists:financeproviders,id',
            'loan_account_number' => 'required|numeric|min:1',
            
            'total_financer_amount'       => 'required|numeric|min:1',
            'total_amount_with_interest'  => 'required|numeric|min:1',
            
            'emi_amount'                  => 'required|numeric|min:1',
            'interest_amount'             => 'required|numeric|min:0',
            
            'emi_total_months'            => 'required|integer|min:1|max:99999999999',
            'emi_paid_upto_months'        => 'nullable|integer|min:0|max:99999999999',
            'emi_left_months'             => 'required|integer|min:0|max:99999999999',
            
            'emi_start_date'              => 'required|date|date_format:Y-m-d',
            'emi_end_date'                => 'required|date|date_format:Y-m-d|after_or_equal:emi_start_date',
            
            'emi_date_of_every_month'     => 'required|integer|between:1,28',
            'set_emi_reminder'            => 'nullable',
            'emi_reminder_before_days'    => 'required_if:set_emi_reminder,on|nullable|integer|in:7,10,20',
            
            'emi_notes'                   => 'nullable|string|max:500',
            
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
                'message' => 'Please check validation errors.'
            ], 422);
        }
        
        
        $exists = Loanaccount::where('vehicle_id', $id)->where('type', $request->finance_type_input)->where('status', '!=', 'Closed')->exists();
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => $request->finance_type_input . ' loan already exists and is not closed.'
            ], 422);
        }
        
        
        
        try {
            
            $loanaccountData = null;
            
            DB::transaction(function () use ($request, &$loanaccountData, $id) {
                
                $loanaccountData = new Loanaccount(); 
                $loanaccountData->vehicle_id = $id;
                $loanaccountData->type = $request->finance_type_input;
                $loanaccountData->financeprovider_id = $request->finance_provider_id;
                $loanaccountData->loan_account_no = $request->loan_account_number;
                $loanaccountData->total_financer_amount = $request->total_financer_amount;
                $loanaccountData->total_amt_with_interest = $request->total_amount_with_interest;
                $loanaccountData->emi_amount = $request->emi_amount;
                $loanaccountData->interest_amount = $request->interest_amount;
                $loanaccountData->total_months = $request->emi_total_months;
                $loanaccountData->paid_upto_months = $request->emi_paid_upto_months ?? 0;
                $loanaccountData->emi_start_date = $request->emi_start_date;
                $loanaccountData->emi_end_date = $request->emi_end_date;
                $loanaccountData->emi_date_every_month = $request->emi_date_of_every_month;
                $loanaccountData->set_reminder = $request->has('set_emi_reminder') ? 'Yes' : 'No';
                $loanaccountData->emi_reminder_before_days = $request->emi_reminder_before_days;
                $loanaccountData->notes = $request->emi_notes;
                $loanaccountData->status = 'Ongoing';
                $loanaccountData->created_by = Auth::user()->id;
                $loanaccountData->save();
                
                // Log
                $loanaccountLog = new Loanaccountlog(); 
                $loanaccountLog->loanaccount_id = $loanaccountData->id;
                $loanaccountLog->vehicle_id = $id;
                $loanaccountLog->type = $request->finance_type_input;
                $loanaccountLog->financeprovider_id = $request->finance_provider_id;
                $loanaccountLog->loan_account_no = $request->loan_account_number;
                $loanaccountLog->total_financer_amount = $request->total_financer_amount;
                $loanaccountLog->total_amt_with_interest = $request->total_amount_with_interest;
                $loanaccountLog->emi_amount = $request->emi_amount;
                $loanaccountLog->interest_amount = $request->interest_amount;
                $loanaccountLog->total_months = $request->emi_total_months;
                $loanaccountLog->paid_upto_months = $request->emi_paid_upto_months ?? 0;
                $loanaccountLog->emi_start_date = $request->emi_start_date;
                $loanaccountLog->emi_end_date = $request->emi_end_date;
                $loanaccountLog->emi_date_every_month = $request->emi_date_of_every_month;
                $loanaccountLog->set_reminder = $request->has('set_emi_reminder') ? 'Yes' : 'No';
                $loanaccountLog->emi_reminder_before_days = $request->emi_reminder_before_days;
                $loanaccountLog->notes = $request->emi_notes;
                $loanaccountLog->created_by = Auth::user()->id;
                $loanaccountLog->save();
                
                
                // Log user activity
                $this->storeUseractivity(67, 3, Auth::user()->id, $loanaccountData->id, 'Added new vehicle EMI details.');
            
            }); 
            
            $success = true;
            $respmessage = 'EMI detail saved successfully.';
    
        } catch (\Exception $exp) {
            
            \Log::error('EMI detail save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $loanaccountData, 'message' => $respmessage]);
        
    }
    
    
    
    
    public function editEmi($id)
    {
        if($id == ''){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! id not found.']);
        }
        
        $record = Loanaccount::find($id);
    
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops! Data not found.']);
        }
        
        return response()->json(['success' => true, 'data' => $record, 'message' => 'Show the edit form.']);

    }
    
    
    
    public function updateEmi(Request $request)
    {   
        $record = Loanaccount::find($request->get('id'));
        
        if($record == NULL){
            return response()->json(['success' => false, 'data' => [], 'message' => 'Woops ! Vehicle EMI data not found!'], 422);
        }
        
        $validator = Validator::make($request->all(), [
                        'finance_provider_id' => 'required|exists:financeproviders,id',
                        'loan_account_number' => 'required|numeric|min:1',
                        
                        'total_financer_amount'       => 'required|numeric|min:1',
                        'total_amount_with_interest'  => 'required|numeric|min:1',
                        
                        'emi_amount'                  => 'required|numeric|min:1',
                        'interest_amount'             => 'required|numeric|min:0',
                        
                        'emi_total_months'            => 'required|integer|min:1|max:99999999999',
                        'emi_paid_upto_months'        => 'nullable|integer|min:0|max:99999999999',
                        'emi_left_months'             => 'required|integer|min:0|max:99999999999',
                        
                        'emi_start_date'              => 'required|date|date_format:Y-m-d',
                        'emi_end_date'                => 'required|date|date_format:Y-m-d|after_or_equal:emi_start_date',
                        
                        'emi_date_of_every_month'     => 'required|integer|between:1,28',
                        'set_emi_reminder'            => 'nullable',
                        'emi_reminder_before_days'    => 'required_if:set_emi_reminder,on|nullable|integer|in:7,10,20',
                        
                        'emi_notes'                   => 'nullable|string|max:500',
                        
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
            ]);
    
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Please check validation errors.'
            ], 422);
        }
        
        
        try{
            
            
            DB::transaction(function () use($request, &$record){
                
                $record->financeprovider_id = $request->finance_provider_id;
                $record->loan_account_no = $request->loan_account_number;
                $record->total_financer_amount = $request->total_financer_amount;
                $record->total_amt_with_interest = $request->total_amount_with_interest;
                $record->emi_amount = $request->emi_amount;
                $record->interest_amount = $request->interest_amount;
                $record->total_months = $request->emi_total_months;
                $record->paid_upto_months = $request->emi_paid_upto_months ?? 0;
                $record->emi_start_date = $request->emi_start_date;
                $record->emi_end_date = $request->emi_end_date;
                $record->emi_date_every_month = $request->emi_date_of_every_month;
                $record->set_reminder = $request->has('set_emi_reminder') ? 'Yes' : 'No';
                $record->emi_reminder_before_days = $request->emi_reminder_before_days;
                $record->notes = $request->emi_notes;
                $record->created_by = Auth::user()->id;
                $record->save();
                
                // Log
                $loanaccountLog = new Loanaccountlog(); 
                $loanaccountLog->loanaccount_id = $record->id;
                $loanaccountLog->vehicle_id = $record->vehicle_id;
                $loanaccountLog->type = $record->type;
                $loanaccountLog->financeprovider_id = $record->financeprovider_id;
                $loanaccountLog->loan_account_no = $record->loan_account_no;
                $loanaccountLog->total_financer_amount = $record->total_financer_amount;
                $loanaccountLog->total_amt_with_interest = $record->total_amt_with_interest;
                $loanaccountLog->emi_amount = $record->emi_amount;
                $loanaccountLog->interest_amount = $record->interest_amount;
                $loanaccountLog->total_months = $record->total_months;
                $loanaccountLog->paid_upto_months = $record->paid_upto_months ?? 0;
                $loanaccountLog->emi_start_date = $record->emi_start_date;
                $loanaccountLog->emi_end_date = $record->emi_end_date;
                $loanaccountLog->emi_date_every_month = $record->emi_date_every_month;
                $loanaccountLog->set_reminder = $record->set_reminder;
                $loanaccountLog->emi_reminder_before_days = $record->emi_reminder_before_days;
                $loanaccountLog->notes = $record->notes;
                $loanaccountLog->created_by = Auth::user()->id;
                $loanaccountLog->updated_by = Auth::user()->id;
                $loanaccountLog->save();
                
    
                $description = 'Updated a vehicle EMI details.';
                $useractivity = $this->storeUseractivity(67, 4, Auth::user()->id, $record->id, $description);
                
            });
            
            $success = true;
            $respmessage = 'Vehicle EMI updated successfully.';
            
        } catch (\Exception $exp){
            \Log::error('Vehicle EMI update error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
            
            
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
            
        }
        
        return response()->json(['success' => $success, 'data' => $record, 'message' => $respmessage]);
    }
    
    
    
    
    
    public function saveFinanceNotes(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'loanaccount_cron_given_emi_id' => 'required|exists:loanaccountcrongivenemis,id',
            'payment_record_type' => 'required|in:Note,Extra Charge',

            'extra_charge' => 'required_if:payment_record_type,Extra Charge|nullable|numeric|min:1|max:999999999999999.99999',
        
            'record_notes' => 'required_if:payment_record_type,Note|nullable|string|max:500',
            
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
                'message' => 'Please check validation errors.'
            ], 422);
        }
        
        
        try {
            
            $notesData = null;
            
            DB::transaction(function () use ($request, &$notesData, $id) {
                
                $notesData = new Emipaymentrecordnote(); 
                $notesData->loanaccountcrongivenemi_id = $request->loanaccount_cron_given_emi_id;
                $notesData->type = $request->payment_record_type;
                $notesData->extra_charge = $request->extra_charge ?? 0;
                $notesData->comment = $request->record_notes ?? null;
                $notesData->created_by = Auth::user()->id;
                $notesData->save();
                
                // Log user activity
                $this->storeUseractivity(68, 3, Auth::user()->id, $notesData->id, 'Added new finance note.');
            
            }); 
            
            $success = true;
            $respmessage = 'Finance note saved successfully.';
    
        } catch (\Exception $exp) {
            
            \Log::error('EMI Finance note save error', [
                'message' => $exp->getMessage(),
                'trace' => $exp->getTraceAsString()
            ]);
    
            DB::rollBack();
            $success = false;
            $respmessage = $exp->getMessage();
        }
        
        return response()->json(['success' => $success, 'data' => $notesData, 'message' => $respmessage]);
        
    }
    
    

    public function getFinanceNotes($id)
    {
        try {
            $record = Loanaccountcrongivenemi::with('financeNotes')->find($id);
    
            if (!$record) {
                return response()->json([
                    'success' => false,
                    'data' => [],
                    'message' => 'Woops! No data found!'
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'data' => $record->financeNotes
            ], 200);
    
        } catch (\Exception $e) {
    
            // Optional: log error
            \Log::error('Finance Notes Error: '.$e->getMessage());
    
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Something went wrong!'
            ], 500);
        }
    }



    
    
    
    
    
}

