<?php

namespace App\Http\Controllers;

class VehicleDocumentDashboardController extends Controller
{
    /**
     * All Vehicle Document Dashboard — static view (no dynamic data).
     */
    public function dashboard()
    {
        return view('vehicledocument.dashboard');
    }
}
