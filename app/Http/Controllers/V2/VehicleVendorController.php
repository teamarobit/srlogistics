<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Vehicle Vendor Module V2 — Controller (Gate 1: design preview)
 *
 * Renders the redesigned Vehicle Vendor screens with static/dummy data so the
 * UI/UX can be reviewed and approved before any backend wiring (LDHA Frontend-first).
 *
 * Gate 2 will replace the demo() data with the existing Eloquent models
 * (Contact cotype_id=5 + relcontacts / contactbanks / coattachments) — NO schema
 * changes, reusing the live `contacts` tables. Module-specific (Vehicle Vendor only).
 *
 * Extensions in play (V2-redesign-pattern.md):
 *   E3 bank-details repeater (exactly-one-primary)
 *   E4 supplied-items sub-pages (Vehicle + Route tables, Add modal)
 *   E6 TDS Declaration (coattachtype_id=7) mandatory when tds_percentage is 0 or 1
 */
class VehicleVendorController extends Controller
{
    /* ---------------------------------------------------------------
     | Static demo data (Gate 1 only — replaced by Eloquent at Gate 2)
     | --------------------------------------------------------------- */
    private function demoVendors(): array
    {
        return [
            ['id'=>1,'contactno'=>'VVND-000118','company'=>'Brahmaputra Carriers','name'=>'Pranab Kalita','code'=>'VV-BC-01','vehicles'=>14,'phone'=>'+91 98640 22114','size'=>'Large','rag'=>'Green','status'=>'Active','gst'=>'18AAACB7711P1Z4','owner'=>'Pranab Kalita','city'=>'Guwahati','tds'=>2,'gst_treatment'=>'Registered'],
            ['id'=>2,'contactno'=>'VVND-000117','company'=>'Dibrugarh Fleet Lines','name'=>'Hiren Gogoi','code'=>'VV-DFL-02','vehicles'=>9,'phone'=>'+91 90853 71140','size'=>'Medium','rag'=>'Green','status'=>'Active','gst'=>'18AAFCD2218R1ZP','owner'=>'Hiren Gogoi','city'=>'Dibrugarh','tds'=>1,'gst_treatment'=>'Registered'],
            ['id'=>3,'contactno'=>'VVND-000116','company'=>'Barak Valley Transport','name'=>'Sahil Ahmed','code'=>'VV-BVT-03','vehicles'=>6,'phone'=>'+91 99540 33180','size'=>'Medium','rag'=>'Yellow','status'=>'Active','gst'=>'18AABCB5521K1Z9','owner'=>'Sahil Ahmed','city'=>'Silchar','tds'=>0,'gst_treatment'=>'Unregistered'],
            ['id'=>4,'contactno'=>'VVND-000115','company'=>'Tinsukia Roadways','name'=>'Bhaskar Dutta','code'=>'VV-TR-04','vehicles'=>4,'phone'=>'+91 70028 55090','size'=>'Small','rag'=>'Red','status'=>'Inactive','gst'=>'18AAGCA9967M1Z2','owner'=>'Bhaskar Dutta','city'=>'Tinsukia','tds'=>2,'gst_treatment'=>'Registered'],
            ['id'=>5,'contactno'=>'VVND-000114','company'=>'Nagaon Logistics Co','name'=>'Imran Khan','code'=>'VV-NLC-05','vehicles'=>3,'phone'=>'+91 88110 90233','size'=>'Small','rag'=>'Red','status'=>'Blacklisted','gst'=>'18AACCV6631K1Z9','owner'=>'Imran Khan','city'=>'Nagaon','tds'=>2,'gst_treatment'=>'Registered'],
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
        return ['documents'=>4,'vehicles'=>$v['vehicles'],'routes'=>5,'activity'=>8];
    }

    /* ---------------------------------------------------------------
     | Screens
     | --------------------------------------------------------------- */
    public function dashboard()
    {
        return view('V2.vehiclevendor.dashboard', ['vendors' => $this->demoVendors()]);
    }

    public function index()
    {
        return view('V2.vehiclevendor.index', ['vendors' => $this->demoVendors()]);
    }

    public function create()
    {
        return view('V2.vehiclevendor.create');
    }

    public function show($id)
    {
        $v = $this->findDemo($id);
        return view('V2.vehiclevendor.show', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'overview']);
    }

    public function edit($id)
    {
        $v = $this->findDemo($id);
        return view('V2.vehiclevendor.edit', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'edit']);
    }

    public function documents($id)
    {
        $v = $this->findDemo($id);
        return view('V2.vehiclevendor.documents', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'documents']);
    }

    public function vehicle($id)
    {
        $v = $this->findDemo($id);
        return view('V2.vehiclevendor.vehicle', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'vehicle']);
    }

    public function route($id)
    {
        $v = $this->findDemo($id);
        return view('V2.vehiclevendor.route', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'route']);
    }

    public function activity($id)
    {
        $v = $this->findDemo($id);
        return view('V2.vehiclevendor.activity', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'activity']);
    }
}
