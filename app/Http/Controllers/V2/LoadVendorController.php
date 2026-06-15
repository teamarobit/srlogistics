<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Load Vendor (Broker) Module V2 — Controller (Gate 1: design preview)
 *
 * Renders the redesigned Load Vendor screens with static/dummy data so the UI/UX
 * can be reviewed and approved before any backend wiring (LDHA Frontend-first).
 *
 * Gate 2 will replace the demo() data source with the existing Eloquent models
 * (Contact cotype_id=2 + relations: relcontacts, loadvendorlocations) — NO schema
 * changes, reusing the live tables. Module-specific controller (Load Vendor only).
 */
class LoadVendorController extends Controller
{
    /* ---------------------------------------------------------------
     | Static demo data (Gate 1 only — replaced by Eloquent at Gate 2)
     | --------------------------------------------------------------- */
    private function demoVendors(): array
    {
        return [
            ['id'=>1,'contactno'=>'LV-000087','company'=>'Brahmaputra Carriers','name'=>'Sudhir Sen','code'=>'BRC-01','alias'=>'BPC','size'=>'Large','rag'=>'Green','phone'=>'+91 98640 11223','city'=>'Guwahati','locations'=>5,'status'=>'Active','email'=>'ops@brahmaputracarriers.in'],
            ['id'=>2,'contactno'=>'LV-000086','company'=>'Northeast Freight Lines','name'=>'Rakesh Sharma','code'=>'NEFL-04','alias'=>'NEF','size'=>'Medium','rag'=>'Yellow','phone'=>'+91 90853 44120','city'=>'Dibrugarh','locations'=>3,'status'=>'Active','email'=>'dispatch@nefreight.co'],
            ['id'=>3,'contactno'=>'LV-000085','company'=>'Valley Roadways','name'=>'Anita Das','code'=>'VLR-09','alias'=>'VRW','size'=>'Large','rag'=>'Green','phone'=>'+91 99540 77310','city'=>'Silchar','locations'=>7,'status'=>'Active','email'=>'bookings@valleyroadways.in'],
            ['id'=>4,'contactno'=>'LV-000084','company'=>'Tinsukia Transport Co','name'=>'Bibek Gogoi','code'=>'TTC-02','alias'=>'TTC','size'=>'Small','rag'=>'Yellow','phone'=>'+91 70028 19045','city'=>'Tinsukia','locations'=>2,'status'=>'Inactive','email'=>'po@tinsukiatransport.in'],
            ['id'=>5,'contactno'=>'LV-000083','company'=>'Red Horizon Logistics','name'=>'Imran Ali','code'=>'RHL-11','alias'=>'RHL','size'=>'Medium','rag'=>'Red','phone'=>'+91 88110 23488','city'=>'Nagaon','locations'=>4,'status'=>'Blacklisted','email'=>'info@redhorizon.in'],
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
        return ['customers'=>4, 'locations'=>$v['locations'], 'documents'=>3, 'activity'=>7];
    }

    /* ---------------------------------------------------------------
     | Screens
     | --------------------------------------------------------------- */
    public function dashboard()
    {
        return view('V2.loadvendor.dashboard', ['vendors' => $this->demoVendors()]);
    }

    public function index()
    {
        return view('V2.loadvendor.index', ['vendors' => $this->demoVendors()]);
    }

    public function create()
    {
        return view('V2.loadvendor.create');
    }

    public function show($id)
    {
        $v = $this->findDemo($id);
        return view('V2.loadvendor.show', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'overview']);
    }

    public function edit($id)
    {
        $v = $this->findDemo($id);
        return view('V2.loadvendor.edit', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'edit']);
    }

    public function customers($id)
    {
        $v = $this->findDemo($id);
        return view('V2.loadvendor.customers', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'customers']);
    }

    public function locations($id)
    {
        $v = $this->findDemo($id);
        return view('V2.loadvendor.locations', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'locations']);
    }

    public function documents($id)
    {
        $v = $this->findDemo($id);
        return view('V2.loadvendor.documents', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'documents']);
    }

    public function activity($id)
    {
        $v = $this->findDemo($id);
        return view('V2.loadvendor.activity', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'activity']);
    }
}
