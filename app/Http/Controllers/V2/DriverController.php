<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Driver Module V2 — Controller (Gate 1: design preview)
 *
 * Renders the redesigned Driver screens with static/dummy data so the UI/UX
 * can be reviewed and approved before any backend wiring (LDHA Frontend-first).
 *
 * Gate 2 will replace demoDrivers() with the existing Eloquent models
 * (Contact cotype_id=4 + driverinfo / coaddresses / contactbanks /
 * vehicleallocation / employeeexitdetails relations) — NO schema changes.
 * Module-specific controller (Driver only) per the V2 brief.
 *
 * Extensions applied (see docs/logics/contact/V2-redesign-pattern.md):
 *   E1 Joining + Exit letter standalone print pages
 *   E2 read-only-after-exit lock + amber banner ($isExited)
 *   E3 bank-details repeater (exactly one primary)
 *   E5 Permanent / Present addresses
 */
class DriverController extends Controller
{
    /* ---------------------------------------------------------------
     | Static demo data (Gate 1 only — replaced by Eloquent at Gate 2)
     | --------------------------------------------------------------- */
    private function demoDrivers(): array
    {
        return [
            ['id'=>1,'contactno'=>'000132','driver_code'=>'DR-132','name'=>'Ramesh Bora','category'=>'Line','phone'=>'+91 98640 11223','whatsapp'=>'+91 98640 11223','rag'=>'Green','vehicle'=>'AS01GC4471','status'=>'Active','licence_no'=>'AS-0120190001234','licence_expiry'=>'14 Aug 2029','aadhaar'=>'4821 7740 9921','dob'=>'12 Mar 1988','doj'=>'02 Jan 2022','blood_group'=>'B+','hisab'=>'Fuel','bank'=>'SBI · ****4471','guarantor'=>'Nabin Bora','guarantor_phone'=>'+91 90853 44120','exited'=>false,'exit_date'=>null],
            ['id'=>2,'contactno'=>'000131','driver_code'=>'DR-131','name'=>'Jahir Ali','category'=>'Local','phone'=>'+91 90853 44120','whatsapp'=>'+91 90853 44120','rag'=>'Yellow','vehicle'=>'AS01HC2210','status'=>'Active','licence_no'=>'AS-0120170005521','licence_expiry'=>'03 Feb 2027','aadhaar'=>'9921 5532 1180','dob'=>'21 Jul 1991','doj'=>'18 Jun 2021','blood_group'=>'O+','hisab'=>'Fixed','bank'=>'HDFC · ****2210','guarantor'=>'Sahil Ali','guarantor_phone'=>'+91 70028 19045','exited'=>false,'exit_date'=>null],
            ['id'=>3,'contactno'=>'000130','driver_code'=>'DR-130','name'=>'Dipankar Das','category'=>'Line','phone'=>'+91 99540 77310','whatsapp'=>'+91 99540 77310','rag'=>'Red','vehicle'=>'AS02GC8890','status'=>'Inactive','licence_no'=>'AS-0220160009912','licence_expiry'=>'29 Nov 2026','aadhaar'=>'5521 8890 4471','dob'=>'05 May 1985','doj'=>'11 Mar 2020','blood_group'=>'A+','hisab'=>'Fuel','bank'=>'ICICI · ****8890','guarantor'=>'Pranab Das','guarantor_phone'=>'+91 88110 23488','exited'=>false,'exit_date'=>null],
            ['id'=>4,'contactno'=>'000129','driver_code'=>'DR-129','name'=>'Suresh Tanti','category'=>'Local','phone'=>'+91 70028 19045','whatsapp'=>'+91 70028 19045','rag'=>'Green','vehicle'=>'—','status'=>'Inactive','licence_no'=>'AS-0120150003310','licence_expiry'=>'17 Sep 2025','aadhaar'=>'7740 1180 5532','dob'=>'30 Dec 1979','doj'=>'05 Aug 2019','blood_group'=>'AB+','hisab'=>'Fixed','bank'=>'Axis · ****3310','guarantor'=>'Mukul Tanti','guarantor_phone'=>'+91 98640 11223','exited'=>true,'exit_date'=>'28 May 2026'],
            ['id'=>5,'contactno'=>'000128','driver_code'=>'DR-128','name'=>'Imran Hussain','category'=>'Line','phone'=>'+91 88110 23488','whatsapp'=>'+91 88110 23488','rag'=>'Yellow','vehicle'=>'AS03GC1145','status'=>'Blacklisted','licence_no'=>'AS-0320180007781','licence_expiry'=>'22 Jun 2028','aadhaar'=>'1180 4471 7740','dob'=>'14 Oct 1990','doj'=>'12 Feb 2023','blood_group'=>'B-','hisab'=>'Fuel','bank'=>'SBI · ****1145','guarantor'=>'Karim Hussain','guarantor_phone'=>'+91 99540 77310','exited'=>false,'exit_date'=>null],
        ];
    }

    private function findDemo($id): array
    {
        foreach ($this->demoDrivers() as $d) {
            if ((int)$d['id'] === (int)$id) return $d;
        }
        return $this->demoDrivers()[0];
    }

    private function counts(array $d): array
    {
        return ['joining'=>1,'documents'=>5,'assets'=>3,'bhatta'=>14,'exit'=>($d['exited']?1:0),'activity'=>11];
    }

    /* common payload for hub + submodule pages */
    private function hub($id, string $active): array
    {
        $d = $this->findDemo($id);
        return [
            'd'        => $d,
            'counts'   => $this->counts($d),
            'active'   => $active,
            'isExited' => (bool)$d['exited'],
        ];
    }

    /* ---------------------------------------------------------------
     | Screens
     | --------------------------------------------------------------- */
    public function dashboard()
    {
        return view('V2.driver.dashboard', ['drivers' => $this->demoDrivers()]);
    }

    public function index()
    {
        return view('V2.driver.index', ['drivers' => $this->demoDrivers()]);
    }

    public function create()
    {
        return view('V2.driver.create');
    }

    public function show($id)      { return view('V2.driver.show',      $this->hub($id, 'overview')); }
    public function edit($id)      { return view('V2.driver.edit',      $this->hub($id, 'edit')); }
    public function joining($id)   { return view('V2.driver.joining',   $this->hub($id, 'joining')); }
    public function documents($id) { return view('V2.driver.documents', $this->hub($id, 'documents')); }
    public function assets($id)    { return view('V2.driver.assets',    $this->hub($id, 'assets')); }
    public function bhatta($id)    { return view('V2.driver.bhatta',    $this->hub($id, 'bhatta')); }
    public function exit($id)      { return view('V2.driver.exit',      $this->hub($id, 'exit')); }
    public function activity($id)  { return view('V2.driver.activity',  $this->hub($id, 'activity')); }

    /* E1 — standalone letter print pages (do NOT extend layouts.app) */
    public function joiningLetter($id)
    {
        return view('V2.driver.joining-letter', ['d' => $this->findDemo($id)]);
    }

    public function exitLetter($id)
    {
        return view('V2.driver.exit-letter', ['d' => $this->findDemo($id)]);
    }
}
