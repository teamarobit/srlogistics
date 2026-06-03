<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LrController extends Controller
{
    public function create(){
        return view('lr.create');
    }

    public function print(){
        return view('lr.print');
    }
}
