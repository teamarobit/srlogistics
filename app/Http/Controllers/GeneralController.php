<?php
  
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Tollstation;
use App\Models\Rto;

class GeneralController extends Controller
{
    
    public function getRtoCharges($rtoId)
    {
        try {
            $rto = Rto::where('id', $rtoId)->first();
    
            if (!$rto) {
                return response()->json([
                    'success' => false,
                    'data' => [],
                    'message' => 'RTO not found!'
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'data' => $rto,
                'message' => 'RTO found.'
            ], 200);
    
        } catch (\Exception $e) {
    
            // Optional: log the error
            \Log::error('Error fetching RTO charges', [
                'rto_id' => $rtoId,
                'error'  => $e->getMessage()
            ]);
    
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Something went wrong while fetching RTO charges!'
            ], 500);
        }
    }
    
    
    public function getTollCharges($tollId)
    {
        try {
            $toll = Tollstation::where('id', $tollId)->first();
    
            if (!$toll) {
                return response()->json([
                    'success' => false,
                    'data' => [],
                    'message' => 'Toll not found!'
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'data' => $toll,
                'message' => 'Toll found.'
            ], 200);
    
        } catch (\Exception $e) {
    
            // Optional: log the error
            \Log::error('Error fetching Toll charges', [
                'rto_id' => $tollId,
                'error'  => $e->getMessage()
            ]);
    
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Something went wrong while fetching Toll charges!'
            ], 500);
        }
    }
    
    
    
    
    

    
    
}

