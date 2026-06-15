<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Insurance Vendor Module V2 — Controller (Gate 1: design preview)
 *
 * The lightest contact type (cotype_id = 9). It is a FLAT record — there is no
 * workspace-hub and there are no submodule pages (extension E8). All CRUD happens
 * through a single Add/Edit Bootstrap modal on the List page. The dedicated
 * `insurancecompanies` lookup (Insurancecompany model) is used for the company
 * dropdown — NOT the contacts-person system (extension E9).
 *
 * This controller renders the redesigned screens with static/dummy data so the
 * UI/UX can be reviewed before any backend wiring (LDHA Frontend-first). Gate 2
 * will replace demo() with the existing Eloquent models (Contact cotype_id=9 +
 * Insurancecompany lookup) — NO schema changes — and seed the lookup via a
 * seeder (SD-2), never inside a migration. Module-specific per the V2 brief.
 */
class InsuranceProviderController extends Controller
{
    /* ---------------------------------------------------------------
     | Static demo data (Gate 1 only — replaced by Eloquent at Gate 2)
     | --------------------------------------------------------------- */
    private function demoProviders(): array
    {
        return [
            ['id'=>1,'contactno'=>'INSV-000061','company'=>'New India Assurance Co. Ltd','contact_name'=>'Rajat Bora','code'=>'NIA','phone'=>'+91 98640 11223','whatsapp'=>'+91 98640 11223','email'=>'claims@newindia.co.in','city'=>'Guwahati','state'=>'Assam','gst'=>'18AAACN4165C1ZK','pan'=>'AAACN4165C','tds'=>2,'status'=>'Active'],
            ['id'=>2,'contactno'=>'INSV-000060','company'=>'ICICI Lombard General Insurance','contact_name'=>'Sneha Kalita','code'=>'ICL','phone'=>'+91 90853 44120','whatsapp'=>'','email'=>'motor@icicilombard.com','city'=>'Dibrugarh','state'=>'Assam','gst'=>'18AAACI7351H1Z2','pan'=>'AAACI7351H','tds'=>2,'status'=>'Active'],
            ['id'=>3,'contactno'=>'INSV-000059','company'=>'Bajaj Allianz General Insurance','contact_name'=>'Imran Hussain','code'=>'BAG','phone'=>'+91 99540 77310','whatsapp'=>'+91 99540 77310','email'=>'fleet@bajajallianz.co.in','city'=>'Jorhat','state'=>'Assam','gst'=>'18AAECB8431P1Z9','pan'=>'AAECB8431P','tds'=>2,'status'=>'Active'],
            ['id'=>4,'contactno'=>'INSV-000058','company'=>'United India Insurance Co. Ltd','contact_name'=>'Pooja Agarwal','code'=>'UII','phone'=>'+91 70028 19045','whatsapp'=>'','email'=>'support@uiic.co.in','city'=>'Silchar','state'=>'Assam','gst'=>'18AAACU5552C1ZH','pan'=>'AAACU5552C','tds'=>0,'status'=>'Inactive'],
            ['id'=>5,'contactno'=>'INSV-000057','company'=>'Reliance General Insurance','contact_name'=>'Vikram Nath','code'=>'RGI','phone'=>'+91 88110 23488','whatsapp'=>'+91 88110 23488','email'=>'claims@reliancegeneral.co.in','city'=>'Tinsukia','state'=>'Assam','gst'=>'18AABCR6181N1Z4','pan'=>'AABCR6181N','tds'=>2,'status'=>'Blacklisted'],
            ['id'=>6,'contactno'=>'INSV-000056','company'=>'TATA AIG General Insurance','contact_name'=>'Anita Deka','code'=>'TAG','phone'=>'+91 87654 33210','whatsapp'=>'','email'=>'commercial@tataaig.com','city'=>'Nagaon','state'=>'Assam','gst'=>'18AABCT3518Q1ZP','pan'=>'AABCT3518Q','tds'=>2,'status'=>'Active'],
        ];
    }

    /* ---------------------------------------------------------------
     | KPI summary (dummy — Gate 2 derives from Contact cotype_id=9)
     | --------------------------------------------------------------- */
    private function demoStats(): array
    {
        return [
            'total'       => 61,
            'active'      => 54,
            'inactive'    => 5,
            'blacklisted' => 2,
            'gst'         => 58,   // GST-registered vendors
            'cities'      => 14,   // distinct cities covered
        ];
    }

    /* ---------------------------------------------------------------
     | Screens (Gate 1: Dashboard + List with modal CRUD only)
     | --------------------------------------------------------------- */
    public function dashboard()
    {
        return view('V2.insuranceprovider.dashboard', [
            'providers' => $this->demoProviders(),
            'stats'     => $this->demoStats(),
        ]);
    }

    public function index()
    {
        return view('V2.insuranceprovider.index', [
            'providers' => $this->demoProviders(),
            'stats'     => $this->demoStats(),
        ]);
    }
}
