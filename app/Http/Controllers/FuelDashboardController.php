<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FuelDashboardController extends Controller
{
    /**
     * Fuel Dashboard — static view (no dynamic data).
     */
    public function dashboard()
    {
        return view('fuel.dashboard');
    }
}
