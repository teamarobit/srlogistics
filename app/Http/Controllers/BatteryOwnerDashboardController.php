<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BatteryOwnerDashboardController extends Controller
{
    // ══════════════════════════════════════════════════════════════════════════
    //  BATTERY OWNER DASHBOARD
    //  Read-only view. Sections are static placeholders — data wired later.
    // ══════════════════════════════════════════════════════════════════════════

    public function index(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->toDateString());
        $dateTo   = $request->input('date_to',   now()->toDateString());

        return view('battery.owner-dashboard', compact('dateFrom', 'dateTo'));
    }
}
