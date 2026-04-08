<?php
  
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Country;
use App\Models\State;
use App\Models\City;


class CustomController extends Controller
{
    public function getCities($stateId){
        
        $cities = City::where('state_id', $stateId)->orderBy('name')->get(['id', 'name']);
        
        return $cities;
    }
    
    
}