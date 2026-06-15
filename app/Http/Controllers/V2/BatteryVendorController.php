<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Battery Vendor Module V2 — Controller (Gate 1: design preview)
 *
 * Renders the redesigned Battery Vendor screens with static/dummy data so the UI/UX
 * can be reviewed and approved before any backend wiring (LDHA Frontend-first).
 *
 * Gate 2 will replace the demo() data source with the existing Eloquent models
 * (Contact cotype_id=7 + relations: relcontacts, contactbanks, coattachments, and
 * Battery by vendor_id) — NO schema changes, reusing the live tables.
 * Module-specific controller (Battery Vendor only) per the V2 brief.
 *
 * Battery Vendor specifics (V2-redesign-pattern.md):
 *   E3 bank-details repeater · E4 "Battery" supplied-items sub-page ·
 *   E6 TDS Declaration mandatory when tds_percentage is 0 or 1 ·
 *   E7 gst_number REQUIRED, gst_treatment hard-coded "Registered".
 */
class BatteryVendorController extends Controller
{
    /* ---------------------------------------------------------------
     | Static demo data (Gate 1 only — replaced by Eloquent at Gate 2)
     | --------------------------------------------------------------- */
    private function demoVendors(): array
    {
        return [
            ['id'=>1,'contactno'=>'BV-000042','company'=>'Amaron Power Systems','name'=>'Sudhir Sen','code'=>'AMR-01','gst'=>'18AAACT2727Q1ZW','vehicles'=>14,'batteries'=>9,'phone'=>'+91 98640 11223','whatsapp'=>'+91 98640 11223','city'=>'Guwahati','tds'=>5,'status'=>'Active','email'=>'ops@amaronpower.in'],
            ['id'=>2,'contactno'=>'BV-000041','company'=>'Exide Northeast Distributors','name'=>'Rakesh Sharma','code'=>'EXD-04','gst'=>'18AABCB1209L1Z5','vehicles'=>8,'batteries'=>12,'phone'=>'+91 90853 44120','whatsapp'=>'+91 90853 44120','city'=>'Dibrugarh','tds'=>2,'status'=>'Active','email'=>'sales@exidene.co'],
            ['id'=>3,'contactno'=>'BV-000040','company'=>'Luminous Battery House','name'=>'Anita Das','code'=>'LUM-09','gst'=>'18AAFCN8821R1ZP','vehicles'=>5,'batteries'=>6,'phone'=>'+91 99540 77310','whatsapp'=>'+91 99540 77310','city'=>'Silchar','tds'=>0,'status'=>'Active','email'=>'care@luminoushouse.in'],
            ['id'=>4,'contactno'=>'BV-000039','company'=>'SF Sonic Traders','name'=>'Bibek Gogoi','code'=>'SFS-02','gst'=>'18AAGCA5567M1Z2','vehicles'=>3,'batteries'=>4,'phone'=>'+91 70028 19045','whatsapp'=>'+91 70028 19045','city'=>'Tinsukia','tds'=>1,'status'=>'Inactive','email'=>'po@sfsonic.in'],
            ['id'=>5,'contactno'=>'BV-000038','company'=>'Okaya Power Depot','name'=>'Imran Ali','code'=>'OKY-11','gst'=>'18AACCV2231K1Z9','vehicles'=>6,'batteries'=>0,'phone'=>'+91 88110 23488','whatsapp'=>'+91 88110 23488','city'=>'Nagaon','tds'=>0,'status'=>'Blacklisted','email'=>'info@okayadepot.in'],
        ];
    }

    private function findDemo($id): array
    {
        foreach ($this->demoVendors() as $v) {
            if ((int)$v['id'] === (int)$id) return $v;
        }
        return $this->demoVendors()[0];
    }

    private function counts(array $v): array
    {
        return ['documents'=>4, 'battery'=>$v['batteries'], 'activity'=>7, 'banks'=>2];
    }

    /* ---------------------------------------------------------------
     | Screens
     | --------------------------------------------------------------- */
    public function dashboard()
    {
        return view('V2.batteryvendor.dashboard', ['vendors' => $this->demoVendors()]);
    }

    public function index()
    {
        return view('V2.batteryvendor.index', ['vendors' => $this->demoVendors()]);
    }

    public function create()
    {
        return view('V2.batteryvendor.create');
    }

    public function show($id)
    {
        $v = $this->findDemo($id);
        return view('V2.batteryvendor.show', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'overview']);
    }

    public function edit($id)
    {
        $v = $this->findDemo($id);
        return view('V2.batteryvendor.edit', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'edit']);
    }

    public function documents($id)
    {
        $v = $this->findDemo($id);
        return view('V2.batteryvendor.documents', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'documents']);
    }

    public function battery($id)
    {
        $v = $this->findDemo($id);
        return view('V2.batteryvendor.battery', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'battery']);
    }

    public function activity($id)
    {
        $v = $this->findDemo($id);
        return view('V2.batteryvendor.activity', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'activity']);
    }
}
