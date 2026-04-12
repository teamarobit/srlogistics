<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Seeds 5 Spare Part Vendor contacts (cotype slug = 'sparevendor') for QA testing.
 *
 * Each vendor gets:
 *  • A contacts row (with specialisation stored as comma-separated category IDs)
 *  • 1–2 relcontacts (contact persons)
 *  • 1 contactbanks row
 *
 * Depends on: SparePartCategoriesSeeder (specialisation IDs resolved from that table)
 *
 * Run: php artisan db:seed --class=SpareVendorSeeder
 * Safe to run multiple times (removes existing SPV contacts first).
 */
class SpareVendorSeeder extends Seeder
{
    /** Fallback cotype_id for Spare Part Vendor */
    private const COTYPE_FALLBACK = 8;

    /**
     * Maps legacy shorthand names used in this seeder to canonical category codes
     * defined in SparePartCategoriesSeeder.
     */
    private const SPEC_MAP = [
        'Engine'              => 'ENG',
        'Brakes'              => 'BRK',
        'Filters'             => 'FLT',
        'Electrical'          => 'ELC',
        'Suspension'          => 'SUS',
        'Fluids & Lubricants' => 'FLD',
        'Transmission'        => 'TRN',
        'Tyres & Wheels'      => 'TYR',
        'Body & Cabin'        => 'BOD',
        'Consumables'         => 'CON',
    ];

    public function run(): void
    {
        $now = Carbon::now();

        // ── Resolve cotype_id ───────────────────────────────────────────────
        $cotype   = DB::table('cotypes')->where('slug', 'sparevendor')->first();
        $cotypeId = $cotype ? $cotype->id : self::COTYPE_FALLBACK;

        // ── Resolve category IDs by code ────────────────────────────────────
        $catById = DB::table('wssparepartscategories')
            ->whereNull('deleted_at')
            ->pluck('id', 'code')   // ['ENG' => 1, 'BRK' => 2, ...]
            ->toArray();

        if (empty($catById)) {
            $this->command->error('No spare part categories found. Run SparePartCategoriesSeeder first.');
            return;
        }

        // Helper: convert comma-separated shorthand string → comma-separated IDs
        $resolveSpec = function (string $specString) use ($catById): string {
            $parts = array_map('trim', explode(',', $specString));
            $ids   = [];
            foreach ($parts as $part) {
                $code = self::SPEC_MAP[$part] ?? null;
                if ($code && isset($catById[$code])) {
                    $ids[] = $catById[$code];
                } else {
                    $this->command->warn("  Could not resolve specialisation [{$part}] to a category ID — skipped.");
                }
            }
            return implode(',', $ids);
        };

        // ── Clean up existing test vendors ─────────────────────────────────
        $existing = DB::table('contacts')
            ->where('cotype_id', $cotypeId)
            ->whereNull('deleted_at')
            ->pluck('id')
            ->toArray();

        if (!empty($existing)) {
            DB::table('relcontacts')->whereIn('contact_id', $existing)->delete();
            DB::table('contactbanks')->whereIn('contact_id', $existing)->delete();
            DB::table('contacts')->whereIn('id', $existing)->delete();
            $this->command->warn('  Removed ' . count($existing) . ' existing test spare vendors.');
        }

        // ── Resolve state/city IDs (Telangana → Hyderabad) ─────────────────
        $stateId = DB::table('states')->where('name', 'like', '%Telangana%')->value('id');
        $cityId  = $stateId
            ? DB::table('cities')->where('state_id', $stateId)->where('name', 'like', '%Hyderabad%')->value('id')
            : null;

        // ── Resolve a bank ID ───────────────────────────────────────────────
        $bankId = DB::table('banks')->first()?->id;

        // ── Vendor data (specialisation uses shorthand — resolved below) ────
        $vendors = [
            [
                'contact_name'    => 'Ravi Kumar Spares',
                'company_name'    => 'Ravi Kumar Auto Parts',
                'contact_code'    => 'SPV-001',
                'phone'           => '9876543210',
                'whatsapp'        => '9876543210',
                'specialisation'  => 'Engine,Brakes,Filters',
                'pan_no'          => 'AABCR1234A',
                'address1'        => 'Shop No. 12, Begum Bazar',
                'zipcode'         => '500012',
                'tds_percentage'  => '2.00',
                'status'          => 'Active',
                'persons'         => [
                    ['name' => 'Ravi Kumar',    'position' => 'Owner',   'phone' => '9876543210'],
                    ['name' => 'Suresh Reddy',  'position' => 'Manager', 'phone' => '9876543211'],
                ],
                'bank'            => ['beneficiary' => 'Ravi Kumar Auto Parts', 'account' => '12340100001234', 'ifsc' => 'SBIN0001234'],
            ],
            [
                'contact_name'    => 'Hyderabad Spare Depot',
                'company_name'    => 'HS Depot Pvt Ltd',
                'contact_code'    => 'SPV-002',
                'phone'           => '9700112233',
                'whatsapp'        => '9700112233',
                'specialisation'  => 'Electrical,Suspension',
                'pan_no'          => 'AAACH5678B',
                'address1'        => '45, Nampally Station Road',
                'zipcode'         => '500001',
                'tds_percentage'  => '1.00',
                'status'          => 'Active',
                'persons'         => [
                    ['name' => 'Anil Sharma', 'position' => 'Proprietor', 'phone' => '9700112233'],
                ],
                'bank'            => ['beneficiary' => 'HS Depot Pvt Ltd', 'account' => '98760100005678', 'ifsc' => 'HDFC0001567'],
            ],
            [
                'contact_name'    => 'Deccan Auto Components',
                'company_name'    => 'Deccan Auto Components',
                'contact_code'    => 'SPV-003',
                'phone'           => '9988776655',
                'whatsapp'        => null,
                'specialisation'  => 'Transmission,Fluids & Lubricants',
                'pan_no'          => 'AABPD4321C',
                'address1'        => 'Plot 22, ECIL Cross Road, Secunderabad',
                'zipcode'         => '500094',
                'tds_percentage'  => '2.00',
                'status'          => 'Active',
                'persons'         => [
                    ['name' => 'Prakash Nair', 'position' => 'Director', 'phone' => '9988776655'],
                    ['name' => 'Kavitha Rao',  'position' => 'Sales',    'phone' => '9988776600'],
                ],
                'bank'            => ['beneficiary' => 'Deccan Auto Components', 'account' => '33330100009999', 'ifsc' => 'ICIC0002345'],
            ],
            [
                'contact_name'    => 'SR Auto Traders',
                'company_name'    => 'SR Auto Traders',
                'contact_code'    => 'SPV-004',
                'phone'           => '9111222333',
                'whatsapp'        => '9111222333',
                'specialisation'  => 'Tyres & Wheels,Brakes',
                'pan_no'          => 'AACSR7890D',
                'address1'        => 'Koti Market, Sultan Bazaar',
                'zipcode'         => '500195',
                'tds_percentage'  => '1.00',
                'status'          => 'Active',
                'persons'         => [
                    ['name' => 'Srinivas Rao', 'position' => 'Owner', 'phone' => '9111222333'],
                ],
                'bank'            => ['beneficiary' => 'SR Auto Traders', 'account' => '77770100003210', 'ifsc' => 'PUNB0112200'],
            ],
            [
                'contact_name'    => 'Bharat Parts Suppliers',
                'company_name'    => 'Bharat Parts Suppliers Pvt Ltd',
                'contact_code'    => 'SPV-005',
                'phone'           => '9444555666',
                'whatsapp'        => '9444555666',
                'specialisation'  => 'Engine,Electrical,Body & Cabin',
                'pan_no'          => 'AABFB2468E',
                'address1'        => '101, Auto Nagar, Kukatpally',
                'zipcode'         => '500072',
                'tds_percentage'  => '2.00',
                'status'          => 'Inactive',
                'persons'         => [
                    ['name' => 'Farooq Ahmed', 'position' => 'CEO',      'phone' => '9444555666'],
                    ['name' => 'Divya Menon',  'position' => 'Purchase', 'phone' => '9444555600'],
                ],
                'bank'            => ['beneficiary' => 'Bharat Parts Suppliers Pvt Ltd', 'account' => '55550100007777', 'ifsc' => 'BARB0KUKPTY'],
            ],
        ];

        $contactSeq = DB::table('contacts')->max('id') ?? 0;

        foreach ($vendors as $v) {
            $contactSeq++;

            $resolvedSpec = $resolveSpec($v['specialisation']);

            $contactId = DB::table('contacts')->insertGetId([
                'contactno'       => 'CO-' . str_pad($contactSeq, 6, '0', STR_PAD_LEFT),
                'cotype_id'       => $cotypeId,
                'contact_name'    => $v['contact_name'],
                'company_name'    => $v['company_name'],
                'contact_code'    => $v['contact_code'],
                'ph_prefix'       => '+91',
                'phone'           => $v['phone'],
                'whatsapp_prefix' => $v['whatsapp'] ? '+91' : null,
                'whatsapp'        => $v['whatsapp'],
                'specialisation'  => $resolvedSpec,
                'pan_no'          => $v['pan_no'],
                'tds_percentage'  => $v['tds_percentage'],
                'address1'        => $v['address1'],
                'zipcode'         => $v['zipcode'],
                'state_id'        => $stateId,
                'city_id'         => $cityId,
                'status'          => $v['status'],
                'created_at'      => $now,
                'updated_at'      => $now,
            ]);

            // ── Contact persons ────────────────────────────────────────────
            foreach ($v['persons'] as $person) {
                DB::table('relcontacts')->insert([
                    'contact_id'  => $contactId,
                    'name'        => $person['name'],
                    'position'    => $person['position'],
                    'ph_prefix'   => '+91',
                    'phone'       => $person['phone'],
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ]);
            }

            // ── Bank details ───────────────────────────────────────────────
            if ($bankId) {
                DB::table('contactbanks')->insert([
                    'contact_id'       => $contactId,
                    'is_primary'       => 'Yes',
                    'bank_id'          => $bankId,
                    'beneficiary_name' => $v['bank']['beneficiary'],
                    'account_number'   => $v['bank']['account'],
                    'ifsc_code'        => $v['bank']['ifsc'],
                    'created_at'       => $now,
                    'updated_at'       => $now,
                ]);
            }

            $statusLabel = $v['status'] === 'Active' ? '✅' : '⏸️';
            $specDisplay = $v['specialisation'];
            $this->command->line("  {$statusLabel} {$v['contact_name']} ({$v['contact_code']}) — specialisation IDs: [{$resolvedSpec}]");
        }

        $this->command->info('✅  Seeded ' . count($vendors) . ' spare part vendors (4 Active, 1 Inactive).');
    }
}
