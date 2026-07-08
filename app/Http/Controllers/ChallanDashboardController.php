<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChallanDashboardController extends Controller
{
    /**
     * Challan Dashboard — static view (no dynamic data).
     */
    public function dashboard()
    {
        return view('challan.dashboard');
    }
}
