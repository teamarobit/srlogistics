<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use App\Models\Tyre;
use App\Models\TyreMaintenanceSchedule;

/**
 * Generates Alignment / Rotation maintenance reminders for tyres
 * where the reminder toggle was set at create time (tyres/create-new).
 *
 * Logic (per tyre that has the relevant reminder toggled ON and is currently
 * allocated to a vehicle):
 *   - If (actual_run_km - last_alignment_km) >= alignment_interval_km
 *     AND no open Alignment schedule exists → create one.
 *   - Same for Rotation with rotation_interval_km / last_rotation_km.
 *
 * Status = 'Pending' → picked up by the ERP tyre dashboard and the vehicle
 * workshop widget. No email/SMS side-effects here — those are handled by a
 * separate notification dispatcher (out of scope for this command).
 *
 * Scheduled via bootstrap/app.php: daily at 06:00.
 */
class CheckTyreReminders extends Command
{
    /** @var string */
    protected $signature = 'tyre:check-reminders {--dry-run : Preview without writing schedules}';

    /** @var string */
    protected $description = 'Create Alignment/Rotation maintenance schedules for tyres whose KM interval has been exceeded.';

    public function handle(): int
    {
        $dryRun   = (bool) $this->option('dry-run');
        $created  = 0;
        $skipped  = 0;
        $scanned  = 0;

        $tyres = Tyre::query()
            ->whereNull('deleted_at')
            ->where(function ($q) {
                $q->where('set_reminder_for_alignment', 'Yes')
                  ->orWhere('set_reminder_for_rotation', 'Yes');
            })
            ->where('current_status', 'Allocated')
            ->get();

        foreach ($tyres as $tyre) {
            $scanned++;

            $actualKm = (int) ($tyre->actual_run_km ?? 0);

            // --- Alignment ---
            if ($tyre->set_reminder_for_alignment === 'Yes') {
                $interval = (int) ($tyre->alignment_interval_km ?? 0);
                $lastKm   = (int) ($tyre->last_alignment_km ?? 0);

                if ($interval > 0 && ($actualKm - $lastKm) >= $interval) {
                    $exists = TyreMaintenanceSchedule::where('tyre_id', $tyre->id)
                        ->where('maintenance_item', 'Alignment')
                        ->whereIn('status', ['Scheduled', 'Pending', 'Overdue'])
                        ->whereNull('deleted_at')
                        ->exists();

                    if (! $exists) {
                        if (! $dryRun) {
                            TyreMaintenanceSchedule::create([
                                'tyre_id'          => $tyre->id,
                                'maintenance_item' => 'Alignment',
                                'last_done_date'   => null,
                                'next_due_date'    => now()->toDateString(),
                                'odometer_km'      => $actualKm,
                                'status'           => 'Pending',
                                'notes'            => 'Auto-generated: KM interval reached (' . $interval . ' km).',
                                'created_by'       => null,
                            ]);
                        }
                        $created++;
                        $this->line('  ✓ Alignment due for tyre #' . $tyre->id . ' (' . ($tyre->tyre_serial_number ?? '—') . ')');
                    } else {
                        $skipped++;
                    }
                }
            }

            // --- Rotation ---
            if ($tyre->set_reminder_for_rotation === 'Yes') {
                $interval = (int) ($tyre->rotation_interval_km ?? 0);
                $lastKm   = (int) ($tyre->last_rotation_km ?? 0);

                if ($interval > 0 && ($actualKm - $lastKm) >= $interval) {
                    $exists = TyreMaintenanceSchedule::where('tyre_id', $tyre->id)
                        ->where('maintenance_item', 'Rotation')
                        ->whereIn('status', ['Scheduled', 'Pending', 'Overdue'])
                        ->whereNull('deleted_at')
                        ->exists();

                    if (! $exists) {
                        if (! $dryRun) {
                            TyreMaintenanceSchedule::create([
                                'tyre_id'          => $tyre->id,
                                'maintenance_item' => 'Rotation',
                                'last_done_date'   => null,
                                'next_due_date'    => now()->toDateString(),
                                'odometer_km'      => $actualKm,
                                'status'           => 'Pending',
                                'notes'            => 'Auto-generated: KM interval reached (' . $interval . ' km).',
                                'created_by'       => null,
                            ]);
                        }
                        $created++;
                        $this->line('  ✓ Rotation due for tyre #' . $tyre->id . ' (' . ($tyre->tyre_serial_number ?? '—') . ')');
                    } else {
                        $skipped++;
                    }
                }
            }
        }

        $this->info("Tyre reminder scan complete.  Scanned: {$scanned}  Created: {$created}  Skipped (already open): {$skipped}" . ($dryRun ? '  [DRY RUN]' : ''));

        return self::SUCCESS;
    }
}
