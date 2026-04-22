<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Widens tyrelogs.tyre_condition ENUM to match the widened set on tyres
 * (see 2026_04_21_122320_add_create_new_fields_to_tyres_table.php).
 *
 * Needed so the new create-new flow can write lifecycle log entries
 * with condition values 'Used' or 'Retread'.
 */
return new class extends Migration
{
    public function up(): void
    {
        try {
            DB::statement("ALTER TABLE tyrelogs MODIFY tyre_condition ENUM('New','Re-thread','Retread','Used','Used Good','Discard','Scrap') NOT NULL");
        } catch (\Throwable $e) {
            // Non-MySQL engine or column already widened — skip silently.
        }
    }

    public function down(): void
    {
        try {
            DB::statement("ALTER TABLE tyrelogs MODIFY tyre_condition ENUM('New','Re-thread','Discard') NOT NULL");
        } catch (\Throwable $e) {
            // ignore
        }
    }
};
