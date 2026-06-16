<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LrController extends Controller
{
    public function create(){
        return view('lr.create');
    }

    public function print(Request $request){
        $trip = $request->query('trip');
        return view('lr.print', compact('trip'));
    }
}
