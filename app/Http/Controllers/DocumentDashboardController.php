<?php

namespace App\Http\Controllers;

class DocumentDashboardController extends Controller
{
    /**
     * Document Dashboard — static tab shell page (no dynamic data).
     * The page renders empty tab shells only; each tab fetches its
     * partial over AJAX via the tab() endpoint below.
     */
    public function dashboard()
    {
        return view('documentdashboard.dashboard');
    }

    /**
     * Return a single Document Dashboard tab's content (AJAX, lazy-loaded).
     * Whitelisted to prevent arbitrary view inclusion.
     */
    public function tab(string $tab)
    {
        $allowed = [
            'invoice'        => 'documentdashboard.tabs.invoice',
            'rc'             => 'documentdashboard.tabs.rc',
            'speed-governor' => 'documentdashboard.tabs.speed-governor',
            'insurance'      => 'documentdashboard.tabs.insurance',
            'fitness'        => 'documentdashboard.tabs.fitness',
            'tax'            => 'documentdashboard.tabs.tax',
            'permit-1-year'  => 'documentdashboard.tabs.permit-1-year',
            'permit-5-year'  => 'documentdashboard.tabs.permit-5-year',
            'pucc'           => 'documentdashboard.tabs.pucc',
            'vltd'           => 'documentdashboard.tabs.vltd',
        ];

        if (! array_key_exists($tab, $allowed)) {
            return response('Invalid tab.', 404);
        }

        return view($allowed[$tab]);
    }
}
