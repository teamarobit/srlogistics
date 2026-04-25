<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * TyreWarehouseSeeder
 *
 * Seeds 20 warehouse tyres spread across:
 *   • All condition ENUMs: New, Re-thread, Retread, Used, Used Good, Discard, Scrap
 *   • All RAG bands: 🟢 Green (≥50%), 🟡 Amber (20–49%), 🔴 Red (<20%), ⚫ Grey (no fixed_run_km)
 *   • Health levels: 100%, 90%, 80%, 75%, 65%, 60%, 55%, 50%, 40%, 35%,
 *                    30%, 25%, 20%, 15%, 10%, 5%, 3%, 1%, null, null
 *   • Both tyre_type values: Radial, Nylon
 *   • Popular Indian truck tyre brands
 *
 * Run:  php artisan db:seed --class=TyreWarehouseSeeder
 */
class TyreWarehouseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Resolve FK dependencies dynamically ───────────────────────────────
        $vendorId  = DB::table('contacts')
                        ->where('cotype_id', 6)
                        ->where('status', 'Active')
                        ->value('id') ?? 1;

        $userId    = DB::table('users')
                        ->where('is_active', 'Yes')
                        ->value('id') ?? 1;

        $warehouseId = DB::table('warehouses')->value('id') ?? 1;

        $now = Carbon::now();

        // ── Helper: compute warranty end date ─────────────────────────────────
        $warrantyEnd = fn(string $purchaseDate, int $months): string =>
            Carbon::parse($purchaseDate)->addMonths($months)->toDateString();

        // ── 20 Tyre definitions ───────────────────────────────────────────────
        // health_pct = (fixed_run_km - actual_run_km) / fixed_run_km * 100
        // null fixed_run_km → Grey RAG (no lifecycle KM configured)
        $tyres = [

            // ── 🟢 GREEN (≥ 50%) ─── 8 tyres ────────────────────────────────

            // 1. 100% — Brand new, zero run
            [
                'serial'        => 'SRW-001',
                'brand'         => 'Apollo',
                'model'         => 'EnduRace RD',
                'condition'     => 'New',
                'type'          => 'Radial',
                'size'          => '10.00R20',
                'price'         => 14500,
                'fixed_run_km'  => 100000,
                'actual_run_km' => 0,        // 100% health
                'purchase_date' => '2026-03-01',
                'issue_date'    => '2026-03-05',
                'warranty_mo'   => 24,
                'fixed_life_mo' => 36,
                'actual_run_mo' => 0,
                'alignment_km'  => 20000,
                'rotation_km'   => 10000,
            ],

            // 2. 90% health
            [
                'serial'        => 'SRW-002',
                'brand'         => 'Bridgestone',
                'model'         => 'R227',
                'condition'     => 'New',
                'type'          => 'Radial',
                'size'          => '295/80R22.5',
                'price'         => 18000,
                'fixed_run_km'  => 100000,
                'actual_run_km' => 10000,    // 90% health
                'purchase_date' => '2026-02-01',
                'issue_date'    => '2026-02-10',
                'warranty_mo'   => 24,
                'fixed_life_mo' => 36,
                'actual_run_mo' => 2,
                'alignment_km'  => 25000,
                'rotation_km'   => 12000,
            ],

            // 3. 80% health
            [
                'serial'        => 'SRW-003',
                'brand'         => 'MRF',
                'model'         => 'ZLX',
                'condition'     => 'New',
                'type'          => 'Nylon',
                'size'          => '7.50R16',
                'price'         => 9500,
                'fixed_run_km'  => 80000,
                'actual_run_km' => 16000,    // 80% health
                'purchase_date' => '2026-01-15',
                'issue_date'    => '2026-01-20',
                'warranty_mo'   => 18,
                'fixed_life_mo' => 30,
                'actual_run_mo' => 3,
                'alignment_km'  => 20000,
                'rotation_km'   => 10000,
            ],

            // 4. 75% health
            [
                'serial'        => 'SRW-004',
                'brand'         => 'CEAT',
                'model'         => 'Winmile S',
                'condition'     => 'New',
                'type'          => 'Radial',
                'size'          => '10.00R20',
                'price'         => 13200,
                'fixed_run_km'  => 100000,
                'actual_run_km' => 25000,    // 75% health
                'purchase_date' => '2025-12-01',
                'issue_date'    => '2025-12-10',
                'warranty_mo'   => 24,
                'fixed_life_mo' => 36,
                'actual_run_mo' => 5,
                'alignment_km'  => 20000,
                'rotation_km'   => 10000,
            ],

            // 5. 65% health
            [
                'serial'        => 'SRW-005',
                'brand'         => 'JK Tyre',
                'model'         => 'Ranger',
                'condition'     => 'Retread',
                'type'          => 'Radial',
                'size'          => '10.00R20',
                'price'         => 7800,
                'fixed_run_km'  => 80000,
                'actual_run_km' => 28000,    // 65% health
                'purchase_date' => '2025-11-01',
                'issue_date'    => '2025-11-15',
                'warranty_mo'   => 12,
                'fixed_life_mo' => 24,
                'actual_run_mo' => 6,
                'alignment_km'  => 15000,
                'rotation_km'   => 8000,
            ],

            // 6. 60% health
            [
                'serial'        => 'SRW-006',
                'brand'         => 'Goodyear',
                'model'         => 'Duraplus',
                'condition'     => 'New',
                'type'          => 'Radial',
                'size'          => '295/80R22.5',
                'price'         => 19500,
                'fixed_run_km'  => 100000,
                'actual_run_km' => 40000,    // 60% health
                'purchase_date' => '2025-10-01',
                'issue_date'    => '2025-10-10',
                'warranty_mo'   => 24,
                'fixed_life_mo' => 36,
                'actual_run_mo' => 8,
                'alignment_km'  => 25000,
                'rotation_km'   => 12000,
            ],

            // 7. 55% health
            [
                'serial'        => 'SRW-007',
                'brand'         => 'Michelin',
                'model'         => 'X MultiWay',
                'condition'     => 'Retread',
                'type'          => 'Nylon',
                'size'          => '9.00R20',
                'price'         => 8500,
                'fixed_run_km'  => 80000,
                'actual_run_km' => 36000,    // 55% health
                'purchase_date' => '2025-09-01',
                'issue_date'    => '2025-09-15',
                'warranty_mo'   => 12,
                'fixed_life_mo' => 24,
                'actual_run_mo' => 9,
                'alignment_km'  => 15000,
                'rotation_km'   => 8000,
            ],

            // 8. 50% health (boundary of Green)
            [
                'serial'        => 'SRW-008',
                'brand'         => 'Apollo',
                'model'         => 'EnduRace RA',
                'condition'     => 'Used Good',
                'type'          => 'Radial',
                'size'          => '10.00R20',
                'price'         => 6500,
                'fixed_run_km'  => 100000,
                'actual_run_km' => 50000,    // 50% health
                'purchase_date' => '2025-08-01',
                'issue_date'    => '2025-08-20',
                'warranty_mo'   => 12,
                'fixed_life_mo' => 24,
                'actual_run_mo' => 10,
                'alignment_km'  => 20000,
                'rotation_km'   => 10000,
            ],

            // ── 🟡 AMBER (20–49%) ─── 5 tyres ───────────────────────────────

            // 9. 40% health
            [
                'serial'        => 'SRW-009',
                'brand'         => 'Yokohama',
                'model'         => 'RY537',
                'condition'     => 'Used Good',
                'type'          => 'Radial',
                'size'          => '295/80R22.5',
                'price'         => 5800,
                'fixed_run_km'  => 100000,
                'actual_run_km' => 60000,    // 40% health
                'purchase_date' => '2025-06-01',
                'issue_date'    => '2025-06-15',
                'warranty_mo'   => 12,
                'fixed_life_mo' => 24,
                'actual_run_mo' => 12,
                'alignment_km'  => 20000,
                'rotation_km'   => 10000,
            ],

            // 10. 35% health
            [
                'serial'        => 'SRW-010',
                'brand'         => 'MRF',
                'model'         => 'Super Lug',
                'condition'     => 'Used',
                'type'          => 'Nylon',
                'size'          => '7.50R16',
                'price'         => 4200,
                'fixed_run_km'  => 80000,
                'actual_run_km' => 52000,    // 35% health
                'purchase_date' => '2025-05-01',
                'issue_date'    => '2025-05-20',
                'warranty_mo'   => 12,
                'fixed_life_mo' => 24,
                'actual_run_mo' => 13,
                'alignment_km'  => 15000,
                'rotation_km'   => 8000,
            ],

            // 11. 30% health
            [
                'serial'        => 'SRW-011',
                'brand'         => 'CEAT',
                'model'         => 'Milaze',
                'condition'     => 'Used',
                'type'          => 'Radial',
                'size'          => '10.00R20',
                'price'         => 3900,
                'fixed_run_km'  => 100000,
                'actual_run_km' => 70000,    // 30% health
                'purchase_date' => '2025-04-01',
                'issue_date'    => '2025-04-10',
                'warranty_mo'   => 12,
                'fixed_life_mo' => 24,
                'actual_run_mo' => 15,
                'alignment_km'  => 20000,
                'rotation_km'   => 10000,
            ],

            // 12. 25% health
            [
                'serial'        => 'SRW-012',
                'brand'         => 'JK Tyre',
                'model'         => 'RangerXT',
                'condition'     => 'Re-thread',
                'type'          => 'Nylon',
                'size'          => '9.00R20',
                'price'         => 3100,
                'fixed_run_km'  => 80000,
                'actual_run_km' => 60000,    // 25% health
                'purchase_date' => '2025-03-01',
                'issue_date'    => '2025-03-15',
                'warranty_mo'   => 6,
                'fixed_life_mo' => 18,
                'actual_run_mo' => 16,
                'alignment_km'  => 15000,
                'rotation_km'   => 8000,
            ],

            // 13. 20% health (boundary of Amber)
            [
                'serial'        => 'SRW-013',
                'brand'         => 'Apollo',
                'model'         => 'XT7',
                'condition'     => 'Used',
                'type'          => 'Radial',
                'size'          => '10.00R20',
                'price'         => 2800,
                'fixed_run_km'  => 100000,
                'actual_run_km' => 80000,    // 20% health
                'purchase_date' => '2025-02-01',
                'issue_date'    => '2025-02-15',
                'warranty_mo'   => 6,
                'fixed_life_mo' => 18,
                'actual_run_mo' => 18,
                'alignment_km'  => 20000,
                'rotation_km'   => 10000,
            ],

            // ── 🔴 RED (< 20%) ─── 5 tyres ──────────────────────────────────

            // 14. 15% health
            [
                'serial'        => 'SRW-014',
                'brand'         => 'Bridgestone',
                'model'         => 'M729',
                'condition'     => 'Re-thread',
                'type'          => 'Nylon',
                'size'          => '9.00R20',
                'price'         => 2500,
                'fixed_run_km'  => 80000,
                'actual_run_km' => 68000,    // 15% health
                'purchase_date' => '2025-01-01',
                'issue_date'    => '2025-01-20',
                'warranty_mo'   => 6,
                'fixed_life_mo' => 18,
                'actual_run_mo' => 19,
                'alignment_km'  => 15000,
                'rotation_km'   => 8000,
            ],

            // 15. 10% health
            [
                'serial'        => 'SRW-015',
                'brand'         => 'Goodyear',
                'model'         => 'Duraplus 2',
                'condition'     => 'Re-thread',
                'type'          => 'Radial',
                'size'          => '10.00R20',
                'price'         => 2200,
                'fixed_run_km'  => 100000,
                'actual_run_km' => 90000,    // 10% health
                'purchase_date' => '2024-12-01',
                'issue_date'    => '2024-12-15',
                'warranty_mo'   => 6,
                'fixed_life_mo' => 18,
                'actual_run_mo' => 21,
                'alignment_km'  => 20000,
                'rotation_km'   => 10000,
            ],

            // 16. 5% health
            [
                'serial'        => 'SRW-016',
                'brand'         => 'Falken',
                'model'         => 'RI117',
                'condition'     => 'Discard',
                'type'          => 'Nylon',
                'size'          => '9.00R20',
                'price'         => 1800,
                'fixed_run_km'  => 80000,
                'actual_run_km' => 76000,    // 5% health
                'purchase_date' => '2024-10-01',
                'issue_date'    => '2024-10-10',
                'warranty_mo'   => 6,
                'fixed_life_mo' => 18,
                'actual_run_mo' => 23,
                'alignment_km'  => 15000,
                'rotation_km'   => 8000,
            ],

            // 17. 3% health
            [
                'serial'        => 'SRW-017',
                'brand'         => 'Birla',
                'model'         => 'Shakti HD',
                'condition'     => 'Discard',
                'type'          => 'Nylon',
                'size'          => '7.50R16',
                'price'         => 1500,
                'fixed_run_km'  => 80000,
                'actual_run_km' => 77600,    // 3% health
                'purchase_date' => '2024-08-01',
                'issue_date'    => '2024-08-15',
                'warranty_mo'   => 6,
                'fixed_life_mo' => 18,
                'actual_run_mo' => 25,
                'alignment_km'  => 15000,
                'rotation_km'   => 8000,
            ],

            // 18. 1% health
            [
                'serial'        => 'SRW-018',
                'brand'         => 'MRF',
                'model'         => 'ZLX XL',
                'condition'     => 'Scrap',
                'type'          => 'Radial',
                'size'          => '10.00R20',
                'price'         => 1200,
                'fixed_run_km'  => 100000,
                'actual_run_km' => 99000,    // 1% health
                'purchase_date' => '2024-06-01',
                'issue_date'    => '2024-06-20',
                'warranty_mo'   => 6,
                'fixed_life_mo' => 18,
                'actual_run_mo' => 27,
                'alignment_km'  => 20000,
                'rotation_km'   => 10000,
            ],

            // ── ⚫ GREY (no lifecycle KM — RAG not applicable) ── 2 tyres ───

            // 19. Grey — no fixed_run_km configured
            [
                'serial'        => 'SRW-019',
                'brand'         => 'Apollo',
                'model'         => 'EnduRace',
                'condition'     => 'Re-thread',
                'type'          => 'Radial',
                'size'          => '10.00R20',
                'price'         => 3500,
                'fixed_run_km'  => null,
                'actual_run_km' => null,     // ⚫ Grey — no KM lifecycle set
                'purchase_date' => '2025-07-01',
                'issue_date'    => '2025-07-10',
                'warranty_mo'   => 12,
                'fixed_life_mo' => null,
                'actual_run_mo' => null,
                'alignment_km'  => null,
                'rotation_km'   => null,
            ],

            // 20. Grey — no fixed_run_km configured
            [
                'serial'        => 'SRW-020',
                'brand'         => 'CEAT',
                'model'         => 'Winmile',
                'condition'     => 'Used Good',
                'type'          => 'Nylon',
                'size'          => '9.00R20',
                'price'         => 4100,
                'fixed_run_km'  => null,
                'actual_run_km' => null,     // ⚫ Grey — no KM lifecycle set
                'purchase_date' => '2025-06-15',
                'issue_date'    => '2025-06-25',
                'warranty_mo'   => 12,
                'fixed_life_mo' => null,
                'actual_run_mo' => null,
                'alignment_km'  => null,
                'rotation_km'   => null,
            ],

        ]; // end $tyres

        // ── Build and insert rows ─────────────────────────────────────────────
        $rows = [];
        foreach ($tyres as $t) {
            $purchaseDate = $t['purchase_date'];
            $rows[] = [
                'organisation_id'           => 1,                        // SD-12
                'location'                  => 'Warehouse',
                'warehouse_id'              => $warehouseId,
                'contact_id'                => $vendorId,
                'tyre_condition'            => $t['condition'],           // SD-11: Title Case
                'tyre_model'                => $t['model'],
                'tyre_type'                 => $t['type'],
                'tyre_brand'                => $t['brand'],
                'tyre_size'                 => $t['size'],
                'tyre_price'                => $t['price'],
                'tyre_serial_number'        => $t['serial'],
                'tyre_purchase_date'        => $purchaseDate,
                'tyre_issue_date'           => $t['issue_date'],
                'tyre_warranty_months'      => $t['warranty_mo'],
                'tyre_warrenty_end_date'    => $warrantyEnd($purchaseDate, $t['warranty_mo']),
                'fixed_run_km'              => $t['fixed_run_km'],
                'actual_run_km'             => $t['actual_run_km'],
                'fixed_life_months'         => $t['fixed_life_mo'],
                'actual_run_month'          => $t['actual_run_mo'],
                'alignment_interval_km'     => $t['alignment_km'],
                'rotation_interval_km'      => $t['rotation_km'],
                'set_reminder_for_alignment'=> 'No',
                'set_reminder_for_rotation' => 'No',
                'created_by'                => $userId,
                'created_at'                => $now,
                'updated_at'                => $now,
            ];
        }

        DB::table('tyres')->insertOrIgnore($rows);

        if ($this->command) {
            $this->command->info('✅  TyreWarehouseSeeder: ' . count($rows) . ' tyres seeded in Warehouse.');
            $this->command->line('   🟢 Green (≥50%): SRW-001 → SRW-008   (100%, 90%, 80%, 75%, 65%, 60%, 55%, 50%)');
            $this->command->line('   🟡 Amber (20–49%): SRW-009 → SRW-013 (40%, 35%, 30%, 25%, 20%)');
            $this->command->line('   🔴 Red (<20%): SRW-014 → SRW-018     (15%, 10%, 5%, 3%, 1%)');
            $this->command->line('   ⚫ Grey (no KM): SRW-019, SRW-020');
        }
    }
}
