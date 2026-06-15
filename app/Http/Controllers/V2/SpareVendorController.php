<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Spare Part Vendor Module V2 — Controller (Gate 1: design preview)
 *
 * Renders the redesigned Spare Part Vendor screens with static/dummy data so the
 * UI/UX can be reviewed and approved before any backend wiring (LDHA Frontend-first).
 *
 * Gate 2 will replace demo() data with the existing Eloquent models — Contact
 * (cotype_id = 8) + relations: relcontacts, bankDetails (Contactbank), coattachments,
 * and WsSparePartCategory for specialisation/spare-parts. NO schema changes; existing
 * tables reused. Module-specific controller (Spare Part Vendor only) — does NOT touch
 * the existing V1 routes/controller/views.
 *
 * Spare-vendor specifics surfaced here (see docs/logics/contact/sparevendor.md +
 * V2-redesign-pattern.md extensions E3/E4/E6/E7):
 *   - cotype_id = 8
 *   - E3 bank-details repeater (exactly one Primary)
 *   - E4 "Spare Parts" supplied-items sub-page
 *   - E6 TDS Declaration rule (TDS% field; declaration doc on Documents page)
 *   - E7 specialisation (comma-joined WsSparePartCategory IDs), no doc upload in store,
 *        banks delete-and-reinsert on update, toggleSpareVendorStatus + destroySpareVendor.
 */
class SpareVendorController extends Controller
{
    /** cotype_id for Spare Part Vendor (Gate 2 query filter). */
    private const COTYPE_ID = 8;

    /* ---------------------------------------------------------------
     | Static demo data (Gate 1 only — replaced by Eloquent at Gate 2)
     | --------------------------------------------------------------- */
    private function demoVendors(): array
    {
        return [
            ['id'=>1,'contactno'=>'SPV-000042','company'=>'Assam Auto Spares','name'=>'Pranab Kalita','code'=>'AAS-01','gst'=>'18AAACT2727Q1ZW','phone'=>'+91 98640 22115','whatsapp'=>'+91 98640 22115','email'=>'sales@assamautospares.in','city'=>'Guwahati','state'=>'Assam','spec'=>['Engine Parts','Brake System','Filters'],'tds'=>2,'banks'=>2,'items'=>38,'status'=>'Active'],
            ['id'=>2,'contactno'=>'SPV-000041','company'=>'Northeast Parts Hub','name'=>'Ritu Bora','code'=>'NEPH-07','gst'=>'18AABCN5512R1Z3','phone'=>'+91 90853 71200','whatsapp'=>'+91 90853 71200','email'=>'info@neparts.co','city'=>'Dibrugarh','state'=>'Assam','spec'=>['Suspension','Tyres & Tubes'],'tds'=>1,'banks'=>1,'items'=>21,'status'=>'Active'],
            ['id'=>3,'contactno'=>'SPV-000040','company'=>'Valley Diesel Spares','name'=>'Imran Hussain','code'=>'VDS-03','gst'=>'18AACFV8890K1ZP','phone'=>'+91 99540 31077','whatsapp'=>'','email'=>'orders@valleydiesel.in','city'=>'Silchar','state'=>'Assam','spec'=>['Engine Parts','Electricals','Lubricants'],'tds'=>0,'banks'=>2,'items'=>54,'status'=>'Active'],
            ['id'=>4,'contactno'=>'SPV-000039','company'=>'Tinsukia Spare Mart','name'=>'Deepak Agarwal','code'=>'TSM-02','gst'=>'18AADCT1123M1Z8','phone'=>'+91 70028 44190','whatsapp'=>'+91 70028 44190','email'=>'po@tinsukiaspare.in','city'=>'Tinsukia','state'=>'Assam','spec'=>['Filters','Lubricants'],'tds'=>2,'banks'=>1,'items'=>12,'status'=>'Inactive'],
            ['id'=>5,'contactno'=>'SPV-000038','company'=>'Red Star Components','name'=>'Sahil Ahmed','code'=>'RSC-09','gst'=>'18AAECR4456L1ZQ','phone'=>'+91 88110 90233','whatsapp'=>'','email'=>'contact@redstarcomp.in','city'=>'Nagaon','state'=>'Assam','spec'=>['Electricals','Body Parts'],'tds'=>1,'banks'=>1,'items'=>9,'status'=>'Blacklisted'],
        ];
    }

    private function findDemo($id): array
    {
        foreach ($this->demoVendors() as $v) {
            if ((int) $v['id'] === (int) $id) return $v;
        }
        return $this->demoVendors()[0];
    }

    private function counts(array $v): array
    {
        return ['spareparts' => $v['items'], 'documents' => 4, 'activity' => 6, 'banks' => $v['banks']];
    }

    /* ---------------------------------------------------------------
     | Screens
     | --------------------------------------------------------------- */
    public function dashboard()
    {
        return view('V2.sparevendor.dashboard', ['vendors' => $this->demoVendors()]);
    }

    public function index()
    {
        return view('V2.sparevendor.index', ['vendors' => $this->demoVendors()]);
    }

    public function create()
    {
        return view('V2.sparevendor.create');
    }

    public function show($id)
    {
        $v = $this->findDemo($id);
        return view('V2.sparevendor.show', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'overview']);
    }

    public function edit($id)
    {
        $v = $this->findDemo($id);
        return view('V2.sparevendor.edit', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'edit']);
    }

    public function spareparts($id)
    {
        $v = $this->findDemo($id);
        return view('V2.sparevendor.spareparts', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'spareparts']);
    }

    public function documents($id)
    {
        $v = $this->findDemo($id);
        return view('V2.sparevendor.documents', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'documents']);
    }

    public function activity($id)
    {
        $v = $this->findDemo($id);
        return view('V2.sparevendor.activity', ['v' => $v, 'counts' => $this->counts($v), 'active' => 'activity']);
    }
}
