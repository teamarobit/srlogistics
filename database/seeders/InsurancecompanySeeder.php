<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Insurancecompany;

class InsurancecompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            ['name' => 'Bajaj Allianz General Insurance',       'code' => 'BAJAJ'],
            ['name' => 'Bharti AXA General Insurance',          'code' => 'BHARTIAX'],
            ['name' => 'Cholamandalam MS General Insurance',    'code' => 'CHOLA'],
            ['name' => 'Future Generali India Insurance',       'code' => 'FUTGEN'],
            ['name' => 'Go Digit General Insurance',            'code' => 'DIGIT'],
            ['name' => 'HDFC ERGO General Insurance',           'code' => 'HDFCERGO'],
            ['name' => 'ICICI Lombard General Insurance',       'code' => 'ICICILOM'],
            ['name' => 'IFFCO Tokio General Insurance',         'code' => 'IFFCO'],
            ['name' => 'Kotak Mahindra General Insurance',      'code' => 'KOTAK'],
            ['name' => 'Liberty General Insurance',             'code' => 'LIBERTY'],
            ['name' => 'Magma HDI General Insurance',           'code' => 'MAGMA'],
            ['name' => 'National Insurance Company',            'code' => 'NATIONAL'],
            ['name' => 'New India Assurance',                   'code' => 'NEWINDIA'],
            ['name' => 'Oriental Insurance Company',            'code' => 'ORIENTAL'],
            ['name' => 'Raheja QBE General Insurance',          'code' => 'RAHEJA'],
            ['name' => 'Reliance General Insurance',            'code' => 'RELIANCE'],
            ['name' => 'Royal Sundaram General Insurance',      'code' => 'ROYAL'],
            ['name' => 'SBI General Insurance',                 'code' => 'SBI'],
            ['name' => 'Shriram General Insurance',             'code' => 'SHRIRAM'],
            ['name' => 'Star Health and Allied Insurance',      'code' => 'STARHEALTH'],
            ['name' => 'Tata AIG General Insurance',            'code' => 'TATAAIG'],
            ['name' => 'United India Insurance',                'code' => 'UNITEDIND'],
            ['name' => 'Universal Sompo General Insurance',     'code' => 'UNISOMPO'],
            ['name' => 'Zuno General Insurance (Edelweiss)',    'code' => 'ZUNO'],
        ];

        foreach ($companies as $data) {
            Insurancecompany::firstOrCreate(
                ['code' => $data['code']],
                ['name' => $data['name'], 'status' => 'Active']
            );
        }

        $this->command->info('Seeded ' . count($companies) . ' insurance companies.');
    }
}
