<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Employee Module V2 — Controller (Gate 1: design preview)  ·  cotype_id = 3
 *
 * Renders the redesigned Employee screens with static/dummy data so the UI/UX
 * can be reviewed and approved before any backend wiring (LDHA Frontend-first).
 *
 * Gate 2 will replace the demo() data source with the existing Eloquent models
 * (Contact + relations: relcontacts, coaddresses, employeeAssets, workExperiences,
 * salaries, employeeExitDetail, coattachments, activities) — NO schema changes.
 * Module-specific controller (Employee only) per the V2 brief.
 *
 * Extensions applied: E1 standalone letters · E2 read-only-after-exit ($isExited) ·
 * E5 Permanent/Present addresses.
 */
class EmployeeController extends Controller
{
    /* ---------------------------------------------------------------
     | Static demo data (Gate 1 only — replaced by Eloquent at Gate 2)
     | --------------------------------------------------------------- */
    private function demoEmployees(): array
    {
        return [
            ['id'=>1,'contactno'=>'EMP-000312','name'=>'Pranab Bordoloi','work_type'=>'Office Work','branch'=>'Guwahati HO','department'=>'Operations','designation'=>'Dispatch Manager','phone'=>'+91 98640 11223','email'=>'pranab@srlogistics.com','gender'=>'Male','blood_group'=>'B+','doj'=>'2023-02-14','status'=>'Active','exited'=>false],
            ['id'=>2,'contactno'=>'EMP-000311','name'=>'Rinki Das','work_type'=>'Office Work','branch'=>'Guwahati HO','department'=>'Accounts','designation'=>'Accounts Executive','phone'=>'+91 90853 44120','email'=>'rinki@srlogistics.com','gender'=>'Female','blood_group'=>'O+','doj'=>'2024-06-01','status'=>'Active','exited'=>false],
            ['id'=>3,'contactno'=>'EMP-000310','name'=>'Saidul Islam','work_type'=>'Service Center','branch'=>'Dibrugarh SC','department'=>'Maintenance','designation'=>'Senior Technician','phone'=>'+91 99540 77310','email'=>'saidul@srlogistics.com','gender'=>'Male','blood_group'=>'A+','doj'=>'2022-11-09','status'=>'Active','exited'=>false],
            ['id'=>4,'contactno'=>'EMP-000309','name'=>'Hemanta Kalita','work_type'=>'Office Work','branch'=>'Tinsukia Branch','department'=>'HR','designation'=>'HR Officer','phone'=>'+91 70028 19045','email'=>'hemanta@srlogistics.com','gender'=>'Male','blood_group'=>'AB+','doj'=>'2021-03-22','status'=>'Inactive','exited'=>true],
            ['id'=>5,'contactno'=>'EMP-000308','name'=>'Junu Gogoi','work_type'=>'Service Center','branch'=>'Silchar SC','department'=>'Maintenance','designation'=>'Service Coordinator','phone'=>'+91 88110 23488','email'=>'junu@srlogistics.com','gender'=>'Female','blood_group'=>'B-','doj'=>'2025-01-15','status'=>'Active','exited'=>false],
        ];
    }

    private function findDemo($id): array
    {
        foreach ($this->demoEmployees() as $e) {
            if ((int)$e['id'] === (int)$id) return $e;
        }
        return $this->demoEmployees()[0];
    }

    private function counts(array $e): array
    {
        return ['joining'=>2,'documents'=>4,'assets'=>3,'leave'=>6,'salary'=>2,'exit'=>($e['exited']?1:0),'activity'=>9];
    }

    /** Build the common payload for every hub/submodule page. */
    private function payload($id, string $active): array
    {
        $e = $this->findDemo($id);
        return [
            'e'        => $e,
            'counts'   => $this->counts($e),
            'active'   => $active,
            'isExited' => (bool)$e['exited'],   // E2 — single read-only-after-exit flag
        ];
    }

    /* ---------------------------------------------------------------
     | Screens
     | --------------------------------------------------------------- */
    public function dashboard()
    {
        return view('V2.employee.dashboard', ['employees' => $this->demoEmployees()]);
    }

    public function index()
    {
        return view('V2.employee.index', ['employees' => $this->demoEmployees()]);
    }

    public function create()
    {
        return view('V2.employee.create');
    }

    public function show($id)
    {
        return view('V2.employee.show', $this->payload($id, 'overview'));
    }

    public function edit($id)
    {
        return view('V2.employee.edit', $this->payload($id, 'edit'));
    }

    public function joining($id)
    {
        return view('V2.employee.joining', $this->payload($id, 'joining'));
    }

    public function documents($id)
    {
        return view('V2.employee.documents', $this->payload($id, 'documents'));
    }

    public function assets($id)
    {
        return view('V2.employee.assets', $this->payload($id, 'assets'));
    }

    public function leave($id)
    {
        return view('V2.employee.leave', $this->payload($id, 'leave'));
    }

    public function salary($id)
    {
        return view('V2.employee.salary', $this->payload($id, 'salary'));
    }

    public function exit($id)
    {
        return view('V2.employee.exit', $this->payload($id, 'exit'));
    }

    public function activity($id)
    {
        return view('V2.employee.activity', $this->payload($id, 'activity'));
    }

    /* ---------------------------------------------------------------
     | E1 — Standalone print letters (do NOT extend layouts.app)
     | --------------------------------------------------------------- */
    public function joiningLetter($id)
    {
        $e = $this->findDemo($id);
        return view('V2.employee.joining-letter', ['e' => $e]);
    }

    public function exitLetter($id)
    {
        $e = $this->findDemo($id);
        return view('V2.employee.exit-letter', ['e' => $e]);
    }
}
