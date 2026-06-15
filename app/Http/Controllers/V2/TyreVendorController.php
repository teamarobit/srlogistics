<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Tyre Vendor Module V2 — Controller (Gate 1: design preview)
 *
 * Renders the redesigned Tyre Vendor screens with static/dummy data so the UI/UX
 * can be reviewed and approved before any backend wiring (LDHA Frontend-first).
 *
 * Gate 2 will replace the demo() data source with the existing Eloquent models
 * (Contact cotype_id=6 + relations: relcontacts, bankDetails, coattachments,
 * Tyre where contact_id) — NO schema changes, reusing the live tables.
 * Module-specific controller (Tyre Vendor only) per the V2 brief.
 *
 * Extensions applied (V2-redesign-pattern.md):
 *  - E3 bank-details repeater (create/edit)
 *  - E4 "Tyre" supplied-items sub-page
 *  - E6 TDS Declaration mandatory when tds_percentage is 0 or 1
 *  - E7 Tyre Vendor has NO size field
 */
class TyreVendorController extends Controller
{
    /* ---------------------------------------------------------------
     | Static demo data (Gate 1 only — replaced by Eloquent at Gate 2)
     | --------------------------------------------------------------- */
    private function demoVendors(): array
    {
        return [
            ['id'=>1,'contactno'=>'TYV-000042','company'=>'MRF Distributors','name'=>'Pranab Kalita','code'=>'MRF-01','phone'=>'+91 98640 55102','city'=>'Guwahati','tyres'=>24,'tds'=>5,'status'=>'Active','gst'=>'18AAACT2727Q1ZW','gst_treatment'=>'Registered','email'=>'sales@mrfdist.in'],
            ['id'=>2,'contactno'=>'TYV-000041','company'=>'Apollo Tyre Centre','name'=>'Rofiqul Islam','code'=>'APL-07','phone'=>'+91 90853 22411','city'=>'Dibrugarh','tyres'=>18,'tds'=>2,'status'=>'Active','gst'=>'18AABCB1209L1Z5','gst_treatment'=>'Registered','email'=>'sales@apollocentre.in'],
            ['id'=>3,'contactno'=>'TYV-000040','company'=>'JK Tyre Agency','name'=>'Nayan Bora','code'=>'JK-03','phone'=>'+91 99540 88120','city'=>'Jorhat','tyres'=>31,'tds'=>1,'status'=>'Active','gst'=>'18AAFCN8821R1ZP','gst_treatment'=>'Registered','email'=>'ops@jktyreagency.in'],
            ['id'=>4,'contactno'=>'TYV-000039','company'=>'CEAT Wheels & Tyres','name'=>'Hiren Saikia','code'=>'CEAT-12','phone'=>'+91 70028 41190','city'=>'Tinsukia','tyres'=>9,'tds'=>0,'status'=>'Inactive','gst'=>'18AAGCA5567M1Z2','gst_treatment'=>'Unregistered','email'=>'po@ceatwheels.in'],
            ['id'=>5,'contactno'=>'TYV-000038','company'=>'Bridgestone Hub','name'=>'Imran Ahmed','code'=>'BRG-05','phone'=>'+91 88110 67432','city'=>'Silchar','tyres'=>0,'tds'=>10,'status'=>'Blacklisted','gst'=>'18AACCV2231K1Z9','gst_treatment'=>'Registered','email'=>'info@bridgestonehub.in'],
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
        return ['documents'=>4, 'tyres'=>$v['tyres'], 'activity'=>7];
    }

    /* ---------------------------------------------------------------
     | Screens
     | --------------------------------------------------------------- */
    public function dashboard()
    {
        return view('V2.tyrevendor.dashboard', ['vendors' => $this->demoVendors()]);
    }

    public function index()
    {
        return view('V2.tyrevendor.index', ['vendors' => $this->demoVendors()]);
    }

    public function create()
    {
        return view('V2.tyrevendor.create');
    }

    public function show($id)
    {
        $v = $this->findDemo($id);
        return view('V2.tyrevendor.show', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'overview']);
    }

    public function edit($id)
    {
        $v = $this->findDemo($id);
        return view('V2.tyrevendor.edit', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'edit']);
    }

    public function documents($id)
    {
        $v = $this->findDemo($id);
        return view('V2.tyrevendor.documents', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'documents']);
    }

    public function tyre($id)
    {
        $v = $this->findDemo($id);
        return view('V2.tyrevendor.tyre', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'tyre']);
    }

    public function activity($id)
    {
        $v = $this->findDemo($id);
        return view('V2.tyrevendor.activity', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'activity']);
    }
}
