<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TollDashboardController extends Controller
{
    /**
     * Toll Dashboard — static view (no dynamic data).
     */
    public function dashboard()
    {
        return view('toll.dashboard');
    }
}
