<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Seeds 5 major Indian vehicle insurance company contacts.
 *
 * cotype slug: 'insuranceprovider'  (created by migration 2026_04_12_140001)
 *
 * Each insurer gets:
 *  • A contacts row  (company_name, contact_name, phone, email, gst_number, state)
 *  • 1 relcontacts row (key account / branch manager)
 *
 * Run:   php artisan db:seed --class=InsuranceProviderSeeder
 * Safe to run multiple times — removes existing insuranceprovider contacts first.
 */
class InsuranceProviderSeeder extends Seeder
{
    /** Fallback cotype_id for Insurance Provider */
    private const COTYPE_FALLBACK = 9;

    public function run(): void
    {
        $now = Carbon::now();

        // ── Resolve cotype_id ───────────────────────────────────────────────
        $cotype   = DB::table('cotypes')->where('slug', 'insuranceprovider')->first();
        $cotypeId = $cotype ? $cotype->id : self::COTYPE_FALLBACK;

        if (!$cotype) {
            $this->command->warn('  cotype [insuranceprovider] not found in DB — using fallback ID ' . self::COTYPE_FALLBACK);
            $this->command->warn('  Run migration 2026_04_12_140001 or CotypesTableSeeder to fix this.');
        }

        // ── Clean up existing test insurers ─────────────────────────────────
        $existing = DB::table('contacts')
            ->where('cotype_id', $cotypeId)
            ->whereNull('deleted_at')
            ->pluck('id')
            ->toArray();

        if (!empty($existing)) {
            DB::table('relcontacts')->whereIn('contact_id', $existing)->delete();
            DB::table('contacts')->whereIn('id', $existing)->delete();
            $this->command->warn('  Removed ' . count($existing) . ' existing insurance provider contacts.');
        }

        // ── Resolve state IDs ───────────────────────────────────────────────
        $state = function (string $name): ?int {
            return DB::table('states')->where('name', 'like', "%{$name}%")->value('id');
        };

        $maharashtraId    = $state('Maharashtra');
        $delhiId          = $state('Delhi');
        $tamilNaduId      = $state('Tamil Nadu');
        $karnatakaId      = $state('Karnataka');
        $telanganaId      = $state('Telangana');

        // ── Insurer data ─────────────────────────────────────────────────────
        $insurers = [
            [
                'company_name'  => 'New India Assurance Co. Ltd.',
                'contact_name'  => 'New India Assurance',
                'contact_code'  => 'INS-001',
                'phone'         => '1800209001',
                'email'         => 'customercare@newindia.co.in',
                'gst_number'    => '27AABCN0569K1ZS',
                'pan_no'        => 'AABCN0569K',
                'address1'      => '87, Mahatma Gandhi Road, Fort',
                'city'          => 'Mumbai',
                'zipcode'       => '400001',
                'state_id'      => $maharashtraId,
                'status'        => 'Active',
                'logo'          => 'logo_new_india.svg',
                'person'        => ['name' => 'Rajesh Pandey',    'position' => 'Zonal Manager',    'phone' => '9022001234'],
            ],
            [
                'company_name'  => 'United India Insurance Co. Ltd.',
                'contact_name'  => 'United India Insurance',
                'contact_code'  => 'INS-002',
                'phone'         => '1800425330',
                'email'         => 'ho@uiic.co.in',
                'gst_number'    => '33AABCU0452R1ZY',
                'pan_no'        => 'AABCU0452R',
                'address1'      => '24, Whites Road, Royapettah',
                'city'          => 'Chennai',
                'zipcode'       => '600014',
                'state_id'      => $tamilNaduId,
                'status'        => 'Active',
                'logo'          => 'logo_united_india.svg',
                'person'        => ['name' => 'Meenakshi Iyer',   'position' => 'Branch Manager',   'phone' => '9044002345'],
            ],
            [
                'company_name'  => 'ICICI Lombard General Insurance Co. Ltd.',
                'contact_name'  => 'ICICI Lombard',
                'contact_code'  => 'INS-003',
                'phone'         => '1800266000',
                'email'         => 'customersupport@icicilombard.com',
                'gst_number'    => '27AAACI1195H1ZQ',
                'pan_no'        => 'AAACI1195H',
                'address1'      => 'ICICI Lombard House, 414 Veer Savarkar Marg, Prabhadevi',
                'city'          => 'Mumbai',
                'zipcode'       => '400025',
                'state_id'      => $maharashtraId,
                'status'        => 'Active',
                'logo'          => 'logo_icici_lombard.svg',
                'person'        => ['name' => 'Vikram Nair',      'position' => 'Key Account Mgr',  'phone' => '9022003456'],
            ],
            [
                'company_name'  => 'Bajaj Allianz General Insurance Co. Ltd.',
                'contact_name'  => 'Bajaj Allianz',
                'contact_code'  => 'INS-004',
                'phone'         => '1800209090',
                'email'         => 'bagichelp@bajajallianz.co.in',
                'gst_number'    => '27AABCB0003A1ZZ',
                'pan_no'        => 'AABCB0003A',
                'address1'      => 'GE Plaza, Airport Road, Yerawada',
                'city'          => 'Pune',
                'zipcode'       => '411006',
                'state_id'      => $maharashtraId,
                'status'        => 'Active',
                'logo'          => 'logo_bajaj_allianz.svg',
                'person'        => ['name' => 'Supriya Kulkarni', 'position' => 'Relationship Mgr', 'phone' => '9022004567'],
            ],
            [
                'company_name'  => 'HDFC ERGO General Insurance Co. Ltd.',
                'contact_name'  => 'HDFC ERGO',
                'contact_code'  => 'INS-005',
                'phone'         => '1800266400',
                'email'         => 'care@hdfcergo.com',
                'gst_number'    => '27AABCH0543A1ZF',
                'pan_no'        => 'AABCH0543A',
                'address1'      => '165-166, Backbay Reclamation, HT Parekh Marg, Churchgate',
                'city'          => 'Mumbai',
                'zipcode'       => '400020',
                'state_id'      => $maharashtraId,
                'status'        => 'Active',
                'logo'          => 'logo_hdfc_ergo.svg',
                'person'        => ['name' => 'Anita Desai',      'position' => 'Fleet Insurance Mgr', 'phone' => '9022005678'],
            ],
        ];

        $contactSeq = DB::table('contacts')->max('id') ?? 0;

        foreach ($insurers as $ins) {
            $contactSeq++;

            $contactId = DB::table('contacts')->insertGetId([
                'contactno'      => 'CO-' . str_pad($contactSeq, 6, '0', STR_PAD_LEFT),
                'cotype_id'      => $cotypeId,
                'company_name'   => $ins['company_name'],
                'contact_name'   => $ins['contact_name'],
                'contact_code'   => $ins['contact_code'],
                'ph_prefix'      => '+91',
                'phone'          => $ins['phone'],
                'email'          => $ins['email'],
                'gst_number'     => $ins['gst_number'],
                'pan_no'         => $ins['pan_no'],
                'address1'       => $ins['address1'],
                'zipcode'        => $ins['zipcode'],
                'state_id'       => $ins['state_id'],
                'status'         => $ins['status'],
                'contact_image'  => $ins['logo'] ?? null,
                'created_at'     => $now,
                'updated_at'     => $now,
            ]);

            // ── Key contact person ─────────────────────────────────────────
            DB::table('relcontacts')->insert([
                'contact_id'  => $contactId,
                'name'        => $ins['person']['name'],
                'position'    => $ins['person']['position'],
                'ph_prefix'   => '+91',
                'phone'       => $ins['person']['phone'],
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);

            $this->command->line("  ✅ {$ins['company_name']} ({$ins['contact_code']}) — ID #{$contactId}");
        }

        $this->command->info('✅  Seeded ' . count($insurers) . ' insurance providers.');
    }
}
