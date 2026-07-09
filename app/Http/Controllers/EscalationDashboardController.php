<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EscalationDashboardController extends Controller
{
    /**
     * Escalation Dashboard — static view (no dynamic data).
     */
    public function dashboard()
    {
        return view('escalation.dashboard');
    }
}
