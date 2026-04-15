<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * TestVehicleSeeder — QA Data Pack
 *
 * Every run creates a FRESH vehicle with a unique registration number.
 * Reference/lookup data (groups, types, providers) is reused if it already
 * exists — no duplicates for master data.
 *
 * Vehicle-specific data (vehicle row + all relations) is always newly inserted.
 *
 * Run:  php artisan db:seed --class=TestVehicleSeeder
 */
class TestVehicleSeeder extends Seeder
{
    public function run(): void
    {
        $orgId  = DB::table('organisations')->value('id') ?? 1;
        $userId = DB::table('users')->value('id') ?? 1;
        $now    = Carbon::now();

        // Unique suffix so each run produces a distinct vehicle reg + serial numbers
        $suffix = strtoupper(substr(md5(microtime()), 0, 4));
        $vehicleNo = 'TS09QA' . $suffix;

        $this->command->info('');
        $this->command->info('━━━ TestVehicleSeeder — QA Data Pack (' . $vehicleNo . ') ━━━━━━━━━━━━━━━━━━━━');

        // ── 1. Vehicle Group (reuse or create) ───────────────────────────────
        $groupId = DB::table('vehiclegroups')
            ->where('organisation_id', $orgId)->where('name', 'Truck')->value('id');
        if (!$groupId) {
            $groupId = DB::table('vehiclegroups')->insertGetId([
                'organisation_id' => $orgId, 'name' => 'Truck',
                'status' => 'Active', 'created_by' => $userId, 'created_at' => $now,
            ]);
            $this->command->info('[+] vehiclegroups: Truck (id=' . $groupId . ')');
        } else {
            $this->command->info('[✓] vehiclegroups: Truck (id=' . $groupId . ')');
        }

        // ── 2. Vehicle Type (reuse or create) ────────────────────────────────
        $typeId = DB::table('vehicletypes')
            ->where('organisation_id', $orgId)->where('name', 'HCV')->value('id');
        if (!$typeId) {
            $typeId = DB::table('vehicletypes')->insertGetId([
                'organisation_id' => $orgId, 'name' => 'HCV',
                'status' => 'Active', 'created_by' => $userId, 'created_at' => $now,
            ]);
            $this->command->info('[+] vehicletypes: HCV (id=' . $typeId . ')');
        } else {
            $this->command->info('[✓] vehicletypes: HCV (id=' . $typeId . ')');
        }

        // ── 3. Vehicle Type Size (reuse or create) ───────────────────────────
        $sizeId = DB::table('vehicletypesizes')
            ->where('vehicletype_id', $typeId)->where('name', '12 Tyre')->value('id');
        if (!$sizeId) {
            $sizeId = DB::table('vehicletypesizes')->insertGetId([
                'vehicletype_id' => $typeId, 'name' => '12 Tyre',
                'height' => '0', 'width' => '0', 'length' => '0',
                'created_at' => $now,
            ]);
            $this->command->info('[+] vehicletypesizes: 12 Tyre (id=' . $sizeId . ')');
        } else {
            $this->command->info('[✓] vehicletypesizes: 12 Tyre (id=' . $sizeId . ')');
        }

        // ── 4. Vehicle (always new) ──────────────────────────────────────────
        $vehicleId = DB::table('vehicles')->insertGetId([
            'organisation_id'    => $orgId,
            'ownership_type'     => 'Own',
            'vehicle_no'         => $vehicleNo,
            'vehiclegroup_id'    => $groupId,
            'vehicletype_id'     => $typeId,
            'vehicletypesize_id' => $sizeId,
            'mounted_tyre_count' => 12,
            'category'           => 'Line',
            'status'             => 'Active',
            'created_by'         => $userId,
            'created_at'         => $now,
            'updated_at'         => $now,
        ]);
        $this->command->info('[+] vehicles: ' . $vehicleNo . ' (id=' . $vehicleId . ')');

        // ── 5. Vehicle Basic Info (always new) ───────────────────────────────
        DB::table('vehiclebasicinfos')->insert([
            'vehicle_id'             => $vehicleId,
            'vehicle_number'         => $vehicleNo,
            'owner_name'             => 'SR Logistics Pvt Ltd',
            'owner_address'          => 'Plot 42, Industrial Area, Patancheru, Hyderabad — 502319',
            'owner_phone'            => '04023456789',
            'registration_date'      => '2021-03-15',
            'registration_status'    => 'Active',
            'manufacturer'           => 'Tata Motors',
            'model'                  => 'Prima 4928.S',
            'vehicle_class'          => 'HGV',
            'vehicle_category'       => 'N3',
            'body_type'              => 'Full Trailer',
            'fuel_type'              => 'Diesel',
            'emission_norms'         => 'BS VI',
            'engine_no'              => 'TM4928S' . $suffix . 'EN001',
            'chassis_no'             => 'MAT45202' . $suffix . '00042',
            'gross_vehicle_weight'   => 49000,
            'unladen_weight'         => 14200,
            'wheelbase'              => 4750,
            'permit_type'            => 'National',
            'permit_no'              => 'TS/NP/2021/' . $vehicleNo,
            'permit_expiry'          => Carbon::now()->addMonths(11)->toDateString(),
            'national_permit_expiry' => Carbon::now()->addMonths(11)->toDateString(),
            'fitness_expiry'         => Carbon::now()->addMonths(5)->toDateString(),
            'insurer'                => 'ICICI Lombard General Insurance',
            'insurance_no'           => 'ICICILOM/CV/2025/' . $vehicleNo,
            'insurance_expiry'       => Carbon::now()->addMonths(20)->toDateString(),
            'pucc_no'                => 'PUCC/HYD/2025/' . $suffix,
            'pucc_expiry'            => Carbon::now()->addMonths(6)->toDateString(),
            'tax_expiry'             => Carbon::now()->addMonths(14)->toDateString(),
            'commercial_fastag'      => 'Yes',
            'fastagId'               => 'FT' . $suffix . '543210',
            'fastag_issue_date'      => '2021-04-01',
            'maker_model'            => 'Tata Prima 4928.S',
            'financer'               => 'HDFC Bank Ltd',
            'class'                  => 'Transport Vehicle',
            'norms_type'             => 'BSVI',
            'created_at'             => $now,
            'updated_at'             => $now,
        ]);
        $this->command->info('[+] vehiclebasicinfos: RC + insurance data');

        // ── 6. Vehicle Group Tracking (reuse or create) ──────────────────────
        $groupTrackingId = DB::table('vehiclegrouptrackings')
            ->where('vehicle_group_id', $groupId)->where('organisation_id', $orgId)
            ->whereNull('deleted_at')->value('id');
        if (!$groupTrackingId) {
            $groupTrackingId = DB::table('vehiclegrouptrackings')->insertGetId([
                'organisation_id'     => $orgId,
                'ownership_type'      => 'Own',
                'vehicle_group_id'    => $groupId,
                'managed_by_employee' => 'Ravi Kumar',
                'no_of_vehicles'      => 8,
                'created_by'          => $userId,
                'created_at'          => $now,
                'updated_at'          => $now,
            ]);
            $this->command->info('[+] vehiclegrouptrackings: Truck group (id=' . $groupTrackingId . ')');
        } else {
            $this->command->info('[✓] vehiclegrouptrackings: (id=' . $groupTrackingId . ')');
        }

        // ── 7. Tracking Vehicles (always new — this vehicle ↔ group link) ────
        DB::table('trackingvehicles')->insert([
            'vehiclegrouptracking_id' => $groupTrackingId,
            'vehicle_id'              => $vehicleId,
            'created_at'              => $now,
            'updated_at'              => $now,
        ]);
        $this->command->info('[+] trackingvehicles: ' . $vehicleNo . ' → Truck group');

        // ── 8. GPS Provider (reuse or create) ────────────────────────────────
        $gpsProviderId = DB::table('gpsproviders')->where('name', 'Uffizio')->value('id');
        if (!$gpsProviderId) {
            $gpsProviderId = DB::table('gpsproviders')->insertGetId([
                'name' => 'Uffizio', 'code' => 'UFZ', 'status' => 'Active',
                'created_by' => $userId, 'created_at' => $now,
            ]);
            $this->command->info('[+] gpsproviders: Uffizio (id=' . $gpsProviderId . ')');
        } else {
            $this->command->info('[✓] gpsproviders: Uffizio (id=' . $gpsProviderId . ')');
        }

        // ── 9. Vehicle GPS (always new) ──────────────────────────────────────
        DB::table('vehiclegps')->insert([
            'vehicle_id'                => $vehicleId,
            'gpsprovider_id'            => $gpsProviderId,
            'gps_type'                  => 'New',
            'gps_plan_cost'             => 3600,
            'gps_device_cost'           => 4500,
            'device_issue_date'         => '2021-04-01',
            'device_warranty'           => 12,
            'device_remaining_warranty' => 0,
            'gps_plan_validity'         => 12,
            'gps_plan_start_date'       => Carbon::now()->subMonths(3)->toDateString(),
            'gps_plan_renew_date'       => Carbon::now()->addMonths(9)->toDateString(),
            'status'                    => 'Active',
            'created_by'                => $userId,
            'created_at'                => $now,
            'updated_at'                => $now,
        ]);
        $this->command->info('[+] vehiclegps: Uffizio fitted');

        // ── 10. FASTag Provider (reuse or create) ─────────────────────────────
        $fasttagProviderId = DB::table('fasttagproviders')->where('name', 'HDFC Bank')->value('id');
        if (!$fasttagProviderId) {
            $fasttagProviderId = DB::table('fasttagproviders')->insertGetId([
                'name' => 'HDFC Bank', 'code' => 'HDFC', 'status' => 'Active',
                'created_by' => $userId, 'created_at' => $now,
            ]);
            $this->command->info('[+] fasttagproviders: HDFC Bank (id=' . $fasttagProviderId . ')');
        } else {
            $this->command->info('[✓] fasttagproviders: HDFC Bank (id=' . $fasttagProviderId . ')');
        }

        // ── 11. Vehicle FASTag (always new) ──────────────────────────────────
        DB::table('vehiclefasttags')->insert([
            'vehicle_id'         => $vehicleId,
            'fasttagprovider_id' => $fasttagProviderId,
            'fasttag_bank_name'  => 'HDFC Bank',
            'fasttagId'          => 'FT' . $suffix . '543210',
            'fasttag_issue_date' => '2021-04-01',
            'created_by'         => $userId,
            'created_at'         => $now,
            'updated_at'         => $now,
        ]);
        $this->command->info('[+] vehiclefasttags: HDFC FASTag');

        // ── 12. Batteries (always new — 2 per vehicle) ───────────────────────
        foreach ([
            ['Exide HEXAFRESH', '180Ah', 'Exide', 'EX180HXF-' . $suffix . '-1', 8200, '2023-06-10', '2023-06-12', 24, 36],
            ['Exide HEXAFRESH', '180Ah', 'Exide', 'EX180HXF-' . $suffix . '-2', 8200, '2023-06-10', '2023-06-12', 24, 36],
        ] as $b) {
            DB::table('vehiclebatteries')->insert([
                'vehicle_id'             => $vehicleId,
                'battery_model_name'     => $b[0],
                'battery_capacity'       => $b[1],
                'battery_brand'          => $b[2],
                'battery_serial_number'  => $b[3],
                'battery_price'          => $b[4],
                'purchase_date'          => $b[5],
                'issue_date'             => $b[6],
                'warranty_months'        => $b[7],
                'fixed_life_months'      => $b[8],
                'created_by'             => $userId,
                'created_at'             => $now,
                'updated_at'             => $now,
            ]);
        }
        $this->command->info('[+] vehiclebatteries: 2 × Exide HEXAFRESH 180Ah');

        // ── 13. Finance Provider (reuse or create) ────────────────────────────
        $finProviderId = DB::table('financeproviders')
            ->where('name', 'like', '%HDFC%')->value('id');
        if (!$finProviderId) {
            $finProviderId = DB::table('financeproviders')->insertGetId([
                'name'       => 'HDFC Bank Ltd',
                'status'     => 'Active',
                'created_by' => $userId,
                'created_at' => $now,
            ]);
            $this->command->info('[+] financeproviders: HDFC Bank Ltd (id=' . $finProviderId . ')');
        } else {
            $this->command->info('[✓] financeproviders: HDFC (id=' . $finProviderId . ')');
        }

        // ── 14. Chassis Loan (always new) ─────────────────────────────────────
        $emiStart = Carbon::create(2021, 5, 1);
        $chassisLoanId = DB::table('loanaccounts')->insertGetId([
            'vehicle_id'              => $vehicleId,
            'type'                    => 'Chassis',
            'financeprovider_id'      => $finProviderId,
            'loan_account_no'         => 'HDFC/TL/2021/' . $suffix . '/CHS',
            'total_financer_amount'   => 2800000,
            'total_amt_with_interest' => 3640000,
            'emi_amount'              => 65000,
            'interest_amount'         => 840000,
            'total_months'            => 56,
            'paid_upto_months'        => 36,
            'emi_start_date'          => $emiStart->toDateString(),
            'emi_end_date'            => $emiStart->copy()->addMonths(55)->toDateString(),
            'emi_date_every_month'    => 5,
            'set_reminder'            => 'Yes',
            'emi_reminder_before_days'=> 3,
            'notes'                   => 'Chassis loan for Tata Prima 4928.S. Balloon payment waived.',
            'status'                  => 'Ongoing',
            'created_by'              => $userId,
            'created_at'              => $now,
            'updated_at'              => $now,
        ]);
        $this->command->info('[+] loanaccounts: Chassis — HDFC ₹28L (id=' . $chassisLoanId . ')');

        // ── 15. Body Loan (always new) ────────────────────────────────────────
        $bodyEmiStart = Carbon::create(2021, 6, 1);
        $bodyLoanId = DB::table('loanaccounts')->insertGetId([
            'vehicle_id'              => $vehicleId,
            'type'                    => 'Body',
            'financeprovider_id'      => $finProviderId,
            'loan_account_no'         => 'HDFC/BL/2021/' . $suffix . '/BOD',
            'total_financer_amount'   => 650000,
            'total_amt_with_interest' => 812500,
            'emi_amount'              => 16250,
            'interest_amount'         => 162500,
            'total_months'            => 50,
            'paid_upto_months'        => 34,
            'emi_start_date'          => $bodyEmiStart->toDateString(),
            'emi_end_date'            => $bodyEmiStart->copy()->addMonths(49)->toDateString(),
            'emi_date_every_month'    => 10,
            'set_reminder'            => 'Yes',
            'emi_reminder_before_days'=> 3,
            'notes'                   => 'Body fabrication loan — Amar Body Builders, Hyderabad.',
            'status'                  => 'Ongoing',
            'created_by'              => $userId,
            'created_at'              => $now,
            'updated_at'              => $now,
        ]);
        $this->command->info('[+] loanaccounts: Body — HDFC ₹6.5L (id=' . $bodyLoanId . ')');

        // ── 16. EMI Records (12 paid EMIs for chassis) — always new ──────────
        $emiBase = Carbon::create(2021, 5, 5);
        for ($m = 0; $m < 12; $m++) {
            DB::table('loanaccountcrongivenemis')->insert([
                'loanaccount_id' => $chassisLoanId,
                'vehicle_id'     => $vehicleId,
                'emi_date'       => $emiBase->copy()->addMonths($m)->toDateString(),
                'emi_amount'     => 65000,
                'status'         => 'Paid',
                'created_at'     => $now,
                'updated_at'     => $now,
            ]);
        }
        $this->command->info('[+] loanaccountcrongivenemis: 12 Paid EMI records');

        // ── 17. Driver Contact (always new — unique contactno) ────────────────
        $driverCotypeId = DB::table('cotypes')->where('slug', 'driver')->value('id') ?? 4;
        $lastContactNo  = DB::table('contacts')->max('contactno') ?? 'CON-0000';
        $nextNo = 'CON-' . str_pad((intval(substr($lastContactNo, 4)) + 1), 4, '0', STR_PAD_LEFT);

        $driverContactId = DB::table('contacts')->insertGetId([
            'organisation_id' => $orgId,
            'contactno'       => $nextNo,
            'contact_name'    => 'Suresh Nayak (' . $suffix . ')',
            'cotype_id'       => $driverCotypeId,
            'phone'           => '98400' . substr(crc32($suffix), 0, 5),
            'status'          => 'Active',
            'created_by'      => $userId,
            'created_at'      => $now,
            'updated_at'      => $now,
        ]);
        $this->command->info('[+] contacts: Driver — Suresh Nayak (' . $suffix . ') contactno=' . $nextNo);

        // ── 18. Driver Allocation (always new) ───────────────────────────────
        DB::table('vehicleallocations')->insert([
            'vehicle_id'     => $vehicleId,
            'contact_id'     => $driverContactId,
            'type'           => 'Driver',
            'change_vehicle' => 'No',
            'created_by'     => $userId,
            'created_at'     => $now,
            'updated_at'     => $now,
        ]);
        $this->command->info('[+] vehicleallocations: Driver → Suresh Nayak (' . $suffix . ')');

        // ── 19. Tyre Vendor (reuse any existing vendor contact) ───────────────
        $tyreVendorId = DB::table('contacts')->whereNull('deleted_at')->value('id') ?? 1;

        // ── 20. Tyre Positions ─────────────────────────────────────────────────
        $positions = DB::table('tyrepositions')->orderBy('id')->take(12)->pluck('id')->toArray();
        if (empty($positions)) {
            $positions = range(1, 12);
        }

        // ── 21. 12 Mounted Tyres (always new, unique serials) ─────────────────
        $tyreData = [
            ['MRF',         'Steel Muscle S97', 'New', '2024-01-10', '2024-01-15', 48200, 14500],
            ['MRF',         'Steel Muscle S97', 'New', '2024-01-10', '2024-01-15', 48200, 14500],
            ['Apollo',      'Endurace RA',      'New', '2024-03-05', '2024-03-10', 35600, 13800],
            ['Apollo',      'Endurace RA',      'New', '2024-03-05', '2024-03-10', 35600, 13800],
            ['Apollo',      'Endurace RA',      'New', '2024-03-05', '2024-03-10', 35600, 13800],
            ['Apollo',      'Endurace RA',      'New', '2024-03-05', '2024-03-10', 35600, 13800],
            ['Bridgestone', 'R179',             'New', '2023-08-20', '2023-08-25', 72400, 15200],
            ['Bridgestone', 'R179',             'New', '2023-08-20', '2023-08-25', 72400, 15200],
            ['Bridgestone', 'R179',             'New', '2023-08-20', '2023-08-25', 72400, 15200],
            ['Bridgestone', 'R179',             'New', '2023-08-20', '2023-08-25', 72400, 15200],
            ['Bridgestone', 'R179',             'New', '2023-08-20', '2023-08-25', 72400, 15200],
            ['Bridgestone', 'R179',             'New', '2023-08-20', '2023-08-25', 72400, 15200],
        ];

        foreach ($tyreData as $i => $t) {
            $serial = $vehicleNo . '-TYR-' . str_pad($i + 1, 2, '0', STR_PAD_LEFT);
            $tyreId = DB::table('tyres')->insertGetId([
                'location'                   => 'Vehicle',
                'warehouse_id'               => null,
                'contact_id'                 => $tyreVendorId,
                'tyre_condition'             => $t[2],
                'tyre_model'                 => $t[0] . ' ' . $t[1],
                'tyre_brand'                 => $t[0],
                'tyre_serial_number'         => $serial,
                'tyre_type'                  => 'Radial',
                'tyre_price'                 => $t[6],
                'tyre_purchase_date'         => $t[3],
                'tyre_issue_date'            => $t[4],
                'tyre_warranty_months'       => 36,
                'tyre_warrenty_end_date'     => Carbon::parse($t[3])->addMonths(36)->toDateString(),
                'fixed_run_km'               => 120000,
                'fixed_life_months'          => 36,
                'actual_run_km'              => $t[5],
                'actual_run_month'           => (int) Carbon::parse($t[3])->diffInMonths($now),
                'alignment_interval_km'      => 20000,
                'set_reminder_for_alignment' => 'Yes',
                'rotation_interval_km'       => 10000,
                'set_reminder_for_rotation'  => 'Yes',
                'last_alignment_km'          => $t[5] - 4200,
                'last_rotation_km'           => $t[5] - 2800,
                'created_by'                 => $userId,
                'created_at'                 => $now,
                'updated_at'                 => $now,
            ]);

            DB::table('vehicletyremapping')->insert([
                'vehicle_id'      => $vehicleId,
                'tyre_id'         => $tyreId,
                'tyreposition_id' => $positions[$i] ?? ($i + 1),
                'created_at'      => $now,
                'updated_at'      => $now,
            ]);
        }
        $this->command->info('[+] tyres + vehicletyremapping: 12 mounted (MRF ×2, Apollo ×4, Bridgestone ×6)');

        // ── Done ──────────────────────────────────────────────────────────────
        $this->command->info('');
        $this->command->info('━━━ QA Data Pack Complete ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('  Vehicle : ' . $vehicleNo . ' — Tata Prima 4928.S  (id=' . $vehicleId . ')');
        $this->command->info('  URL     : /fleet-dashboard/vehicle/' . $vehicleId . '/details');
        $this->command->info('  Driver  : Suresh Nayak (' . $suffix . ')');
        $this->command->info('  GPS     : Uffizio — renews ' . Carbon::now()->addMonths(9)->toDateString());
        $this->command->info('  FASTag  : HDFC Bank — FT' . $suffix . '543210');
        $this->command->info('  Loans   : Chassis ₹28L + Body ₹6.5L (HDFC)');
        $this->command->info('  Tyres   : 12 mounted across 3 axles');
        $this->command->info('  Insurance: ICICI Lombard — expires ' . Carbon::now()->addMonths(20)->toDateString());
        $this->command->info('');
    }
}
