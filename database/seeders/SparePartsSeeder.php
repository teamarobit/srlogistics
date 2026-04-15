<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Seeds the wsspareparts master table with 38 sample parts.
 * Uses category_id FK (resolved from wssparepartscategories by code).
 *
 * Depends on: SparePartCategoriesSeeder (run that first)
 * current_stock is not stored here — stock is per-location in wsstockbalances.
 *
 * Run: php artisan db:seed --class=SparePartsSeeder
 */
class SparePartsSeeder extends Seeder
{
    public function run(): void
    {
        // ── Resolve category IDs by code ────────────────────────────────────
        $catRows = DB::table('wssparepartscategories')
            ->whereNull('deleted_at')
            ->pluck('id', 'code')
            ->toArray();

        if (empty($catRows)) {
            $this->command->error('No spare part categories found. Run SparePartCategoriesSeeder first.');
            return;
        }

        // Helper: get ID by code, warn if missing
        $cat = function (string $code) use ($catRows): ?int {
            if (isset($catRows[$code])) {
                return $catRows[$code];
            }
            $this->command->warn("  Category code [{$code}] not found in wssparepartscategories.");
            return null;
        };

        DB::table('wsspareparts')->truncate();

        $now = Carbon::now();

        // columns: [part_no, name, category_code, compatible_makes, unit, standard_cost, reorder_level, status]
        $parts = [
            // ── Engine Parts ──────────────────────────────────────────────────
            ['SP-0001', 'Engine Oil Filter',            'ENG', 'Tata, Ashok Leyland, Eicher',  'Piece',   85.00,  20, 'Active'],
            ['SP-0002', 'Air Filter (Primary)',          'ENG', 'Tata, Mahindra, Eicher',       'Piece',  320.00,  10, 'Active'],
            ['SP-0003', 'Air Filter (Secondary)',        'ENG', 'Tata, Ashok Leyland',          'Piece',  180.00,  10, 'Active'],
            ['SP-0004', 'Fuel Filter',                   'ENG', 'Tata, Eicher, Volvo',          'Piece',  210.00,  15, 'Active'],
            ['SP-0005', 'V-Belt Set',                    'ENG', 'Tata, Mahindra',               'Set',    450.00,   8, 'Active'],
            ['SP-0006', 'Engine Mounting (Front)',       'ENG', 'Tata 407, Tata 709',           'Piece',  780.00,   5, 'Active'],
            ['SP-0038', 'Gasket Set (Engine Top)',       'ENG', 'Tata, Ashok Leyland',          'Set',    680.00,   6, 'Active'],

            // ── Brake Parts ───────────────────────────────────────────────────
            ['SP-0007', 'Brake Shoe (Front Axle)',       'BRK', 'Tata, Ashok Leyland',          'Set',    620.00,  10, 'Active'],
            ['SP-0008', 'Brake Shoe (Rear Axle)',        'BRK', 'Tata, Ashok Leyland',          'Set',    580.00,  10, 'Active'],
            ['SP-0009', 'Brake Chamber (Type 20)',       'BRK', 'Universal',                    'Piece',  950.00,   6, 'Active'],
            ['SP-0010', 'Slack Adjuster (Automatic)',    'BRK', 'Universal',                    'Piece', 1200.00,   5, 'Active'],
            ['SP-0011', 'Brake Lining Set',              'BRK', 'Tata, Eicher',                 'Set',    390.00,  12, 'Active'],

            // ── Electrical ────────────────────────────────────────────────────
            ['SP-0012', 'Starter Motor Assembly',        'ELC', 'Tata, Ashok Leyland',          'Piece', 3800.00,   3, 'Active'],
            ['SP-0013', 'Alternator (24V 55A)',          'ELC', 'Tata, Eicher, Volvo',          'Piece', 4200.00,   3, 'Active'],
            ['SP-0014', 'Horn (Air Type)',                'ELC', 'Universal',                    'Piece',  350.00,   8, 'Active'],
            ['SP-0015', 'Headlamp Assembly (LED)',       'ELC', 'Tata 909, Tata 1109',          'Piece', 1100.00,   6, 'Active'],
            ['SP-0016', 'Fuse Box Assembly',             'ELC', 'Tata, Mahindra',               'Piece',  520.00,   4, 'Active'],

            // ── Suspension & Steering ─────────────────────────────────────────
            ['SP-0017', 'Leaf Spring (Front)',           'SUS', 'Tata, Ashok Leyland',          'Piece', 2800.00,   4, 'Active'],
            ['SP-0018', 'Shock Absorber (Front)',        'SUS', 'Tata, Eicher',                 'Piece', 1650.00,   6, 'Active'],
            ['SP-0019', 'Tie Rod End',                   'SUS', 'Tata 407, Tata 709',           'Piece',  780.00,   8, 'Active'],
            ['SP-0020', 'King Pin Kit',                  'SUS', 'Tata, Ashok Leyland',          'Set',   1450.00,   4, 'Active'],

            // ── Fluids & Lubricants ───────────────────────────────────────────
            ['SP-0021', 'Engine Oil 15W40 (5L)',         'FLD', 'Universal',                    'Can',    850.00,  20, 'Active'],
            ['SP-0022', 'Gear Oil EP-90 (1L)',           'FLD', 'Universal',                    'Litre',  220.00,  20, 'Active'],
            ['SP-0023', 'Brake Fluid DOT-3 (500ml)',     'FLD', 'Universal',                    'Piece',  180.00,  15, 'Active'],
            ['SP-0024', 'Coolant (Ready Mix 1L)',        'FLD', 'Universal',                    'Litre',  190.00,  15, 'Active'],
            ['SP-0025', 'Grease (Multi-Purpose 1Kg)',    'FLD', 'Universal',                    'Kg',     280.00,  10, 'Active'],

            // ── Transmission ──────────────────────────────────────────────────
            ['SP-0026', 'Clutch Plate Set',              'TRN', 'Tata, Ashok Leyland, Eicher',  'Set',   3200.00,   4, 'Active'],
            ['SP-0027', 'Pressure Plate Assembly',       'TRN', 'Tata, Ashok Leyland',          'Piece', 2600.00,   3, 'Active'],
            ['SP-0028', 'Gear Shift Lever Boot',         'TRN', 'Tata 407, Tata 709, Tata 909', 'Piece',  120.00,  10, 'Active'],

            // ── Body & Cabin ──────────────────────────────────────────────────
            ['SP-0029', 'Windshield Glass (Tata 909)',   'BOD', 'Tata 909',                     'Piece', 4500.00,   2, 'Active'],
            ['SP-0030', 'Door Mirror (Left)',             'BOD', 'Tata, Eicher',                 'Piece',  680.00,   5, 'Active'],
            ['SP-0031', 'Seat Foam (Driver)',             'BOD', 'Universal',                    'Piece',  950.00,   4, 'Active'],
            ['SP-0032', 'Wiper Blade (22")',              'BOD', 'Universal',                    'Piece',  180.00,  12, 'Active'],

            // ── Tyres & Wheels ────────────────────────────────────────────────
            ['SP-0033', 'Tube (10.00 x 20)',             'TYR', 'Universal',                    'Piece',  850.00,  10, 'Active'],
            ['SP-0034', 'Wheel Nut Set (10 pcs)',        'TYR', 'Universal',                    'Set',    320.00,   8, 'Active'],
            ['SP-0035', 'Valve Core',                    'TYR', 'Universal',                    'Piece',   18.00,  50, 'Active'],

            // ── Consumables ───────────────────────────────────────────────────
            ['SP-0036', 'Cable Tie 300mm (Pack of 100)', 'CON', 'Universal',                    'Pack',    95.00,  20, 'Active'],
            ['SP-0037', 'Nut & Bolt Kit (M12)',          'CON', 'Universal',                    'Set',    145.00,  15, 'Active'],
        ];

        $rows = [];
        foreach ($parts as $i => $p) {
            $rows[] = [
                'id'               => $i + 1,
                'part_no'          => $p[0],
                'name'             => $p[1],
                'wssparepartscategory_id' => $cat($p[2]),   // FK — resolved by code
                'category'         => null,           // legacy column — leave null
                'compatible_makes' => $p[3],
                'unit'             => $p[4],
                'standard_cost'    => $p[5],
                'reorder_level'    => $p[6],
                'status'           => $p[7],
                'notes'            => null,
                'created_by'       => null,
                'updated_by'       => null,
                'deleted_by'       => null,
                'created_at'       => $now,
                'updated_at'       => $now,
                'deleted_at'       => null,
            ];
        }

        DB::table('wsspareparts')->insert($rows);

        $this->command->info('✅  Seeded ' . count($rows) . ' spare parts across ' . count($catRows) . ' categories.');
        $this->command->line('   Category breakdown:');

        $grouped = collect($rows)->groupBy('category_id');
        foreach ($catRows as $code => $id) {
            $count = $grouped->get($id, collect())->count();
            if ($count > 0) {
                $this->command->line("   [{$code}] {$count} parts");
            }
        }
    }
}
