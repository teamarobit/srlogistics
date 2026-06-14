<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Customer Module V2 — Controller (Gate 1: design preview)
 *
 * Renders the redesigned Customer screens with static/dummy data so the UI/UX
 * can be reviewed and approved before any backend wiring (LDHA Frontend-first).
 *
 * Gate 2 will replace the dummy() data source with the existing Eloquent models
 * (Contact + relations) — NO schema changes, reusing the live `contacts` tables.
 * This controller is module-specific (Customer only) per the V2 brief.
 */
class CustomerController extends Controller
{
    /* ---------------------------------------------------------------
     | Static demo data (Gate 1 only — replaced by Eloquent at Gate 2)
     | --------------------------------------------------------------- */
    private function demoCustomers(): array
    {
        return [
            ['id'=>1,'contactno'=>'CUST-000124','name'=>'Sudhir Sen','type'=>'FMCG','size'=>'Large','phone'=>'+91 98640 11223','city'=>'Amguri','locations'=>4,'contracts'=>2,'status'=>'Active','gst'=>'18AAACT2727Q1ZW','email'=>'accounts@sudhirsen.in'],
            ['id'=>2,'contactno'=>'CUST-000123','name'=>'Brahmaputra Traders','type'=>'Cement','size'=>'Medium','phone'=>'+91 90853 44120','city'=>'Guwahati','locations'=>6,'contracts'=>1,'status'=>'Active','gst'=>'18AABCB1209L1Z5','email'=>'ops@brahmaputra.co'],
            ['id'=>3,'contactno'=>'CUST-000122','name'=>'Northeast Steel Pvt Ltd','type'=>'Steel','size'=>'Large','phone'=>'+91 99540 77310','city'=>'Dibrugarh','locations'=>3,'contracts'=>3,'status'=>'Active','gst'=>'18AAFCN8821R1ZP','email'=>'dispatch@nesteel.in'],
            ['id'=>4,'contactno'=>'CUST-000121','name'=>'Assam Agro Foods','type'=>'FMCG','size'=>'Small','phone'=>'+91 70028 19045','city'=>'Tinsukia','locations'=>2,'contracts'=>1,'status'=>'Inactive','gst'=>'18AAGCA5567M1Z2','email'=>'po@assamagro.in'],
            ['id'=>5,'contactno'=>'CUST-000120','name'=>'Valley Distributors','type'=>'Retail','size'=>'Medium','phone'=>'+91 88110 23488','city'=>'Silchar','locations'=>5,'contracts'=>0,'status'=>'Blacklisted','gst'=>'18AACCV2231K1Z9','email'=>'info@valleydist.in'],
        ];
    }

    private function findDemo($id): array
    {
        foreach ($this->demoCustomers() as $c) {
            if ((int)$c['id'] === (int)$id) return $c;
        }
        return $this->demoCustomers()[0];
    }

    private function counts(array $c): array
    {
        return ['contracts'=>$c['contracts'],'locations'=>$c['locations'],'ratecharts'=>5,'vehicles'=>3,'documents'=>4,'activity'=>9];
    }

    /* ---------------------------------------------------------------
     | Screens
     | --------------------------------------------------------------- */
    public function dashboard()
    {
        return view('V2.customer.dashboard', ['customers' => $this->demoCustomers()]);
    }

    public function index()
    {
        return view('V2.customer.index', ['customers' => $this->demoCustomers()]);
    }

    public function create()
    {
        return view('V2.customer.create');
    }

    public function show($id)
    {
        $c = $this->findDemo($id);
        return view('V2.customer.show', ['c' => $c, 'counts' => $this->counts($c), 'active' => 'overview']);
    }

    public function edit($id)
    {
        $c = $this->findDemo($id);
        return view('V2.customer.edit', ['c' => $c, 'counts' => $this->counts($c), 'active' => 'edit']);
    }

    public function contracts($id)
    {
        $c = $this->findDemo($id);
        return view('V2.customer.contracts', ['c' => $c, 'counts' => $this->counts($c), 'active' => 'contracts']);
    }

    public function contractForm($id)
    {
        $c = $this->findDemo($id);
        return view('V2.customer.contract-form', ['c' => $c, 'counts' => $this->counts($c), 'active' => 'contracts']);
    }

    public function locations($id)
    {
        $c = $this->findDemo($id);
        return view('V2.customer.locations', ['c' => $c, 'counts' => $this->counts($c), 'active' => 'locations']);
    }

    public function rateChart($id)
    {
        $c = $this->findDemo($id);
        return view('V2.customer.rate-chart', ['c' => $c, 'counts' => $this->counts($c), 'active' => 'ratechart']);
    }

    public function vehicles($id)
    {
        $c = $this->findDemo($id);
        return view('V2.customer.vehicles', ['c' => $c, 'counts' => $this->counts($c), 'active' => 'vehicles']);
    }

    public function documents($id)
    {
        $c = $this->findDemo($id);
        return view('V2.customer.documents', ['c' => $c, 'counts' => $this->counts($c), 'active' => 'documents']);
    }

    public function activity($id)
    {
        $c = $this->findDemo($id);
        return view('V2.customer.activity', ['c' => $c, 'counts' => $this->counts($c), 'active' => 'activity']);
    }
}
