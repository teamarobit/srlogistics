<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InsurancePurchaseDashboardController extends Controller
{
    /**
     * Purchase Insurance Dashboard — static view (no dynamic data).
     */
    public function dashboard()
    {
        return view('inventory.purchase-insurance.dashboard');
    }
}
