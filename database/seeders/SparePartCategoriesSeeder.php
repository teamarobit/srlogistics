<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Seeds the wssparepartscategories master table.
 *
 * This is the source of truth for:
 *  • wsspareparts.category_id  (spare parts categorisation)
 *  • contacts.specialisation   (spare vendor specialisation chips)
 *
 * Run: php artisan db:seed --class=SparePartCategoriesSeeder
 *
 * Safe to re-run — uses upsert so existing rows are preserved.
 */
class SparePartCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $categories = [
            ['code' => 'ENG',  'name' => 'Engine Parts',          'description' => 'Engine components — filters, mounts, belts, gaskets, cooling parts'],
            ['code' => 'BRK',  'name' => 'Brake Parts',           'description' => 'Brake shoes, chambers, slack adjusters, lining kits'],
            ['code' => 'FLT',  'name' => 'Filters',               'description' => 'Oil, air, fuel and hydraulic filters (cross-category)'],
            ['code' => 'ELC',  'name' => 'Electrical',            'description' => 'Starter motors, alternators, fuses, lighting, horns'],
            ['code' => 'SUS',  'name' => 'Suspension & Steering', 'description' => 'Leaf springs, shock absorbers, tie rods, king pin kits'],
            ['code' => 'FLD',  'name' => 'Fluids & Lubricants',   'description' => 'Engine oils, gear oils, coolants, grease, brake fluids'],
            ['code' => 'TRN',  'name' => 'Transmission',          'description' => 'Clutch plates, pressure plates, gearbox components'],
            ['code' => 'TYR',  'name' => 'Tyres & Wheels',        'description' => 'Tubes, valves, wheel nuts, rims'],
            ['code' => 'BOD',  'name' => 'Body & Cabin',          'description' => 'Glass, mirrors, seat foam, wipers, cabin panels'],
            ['code' => 'CON',  'name' => 'Consumables',           'description' => 'Cable ties, nuts & bolts, tapes, sundry workshop items'],
        ];

        $inserted = 0;
        $skipped  = 0;

        foreach ($categories as $cat) {
            $exists = DB::table('wssparepartscategories')
                        ->where('code', $cat['code'])
                        ->whereNull('deleted_at')
                        ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            DB::table('wssparepartscategories')->insert([
                'name'        => $cat['name'],
                'code'        => $cat['code'],
                'description' => $cat['description'],
                'status'      => 'Active',
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
            $inserted++;
        }

        $this->command->info("✅  Spare Part Categories: {$inserted} inserted, {$skipped} already existed.");

        // Print the final table so dependent seeders can reference it
        $all = DB::table('wssparepartscategories')->whereNull('deleted_at')->orderBy('id')->get(['id', 'code', 'name']);
        foreach ($all as $row) {
            $this->command->line("   [{$row->id}] {$row->code} — {$row->name}");
        }
    }
}
