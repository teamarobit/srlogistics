<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmiDashboardController extends Controller
{
    /**
     * EMI Dashboard — static view (no dynamic data).
     */
    public function dashboard()
    {
        return view('emi.dashboard');
    }
}
