<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Add 'Fitment' to the tyre_source_mode ENUM on the tyres table.
     * MySQL requires re-declaring ALL enum values when altering.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE `tyres` MODIFY COLUMN `tyre_source_mode` ENUM('Existing', 'New PO', 'Fitment') NOT NULL DEFAULT 'Existing'");
    }

    public function down(): void
    {
        // Rows with 'Fitment' will be truncated back — only safe if no Fitment rows exist.
        DB::statement("ALTER TABLE `tyres` MODIFY COLUMN `tyre_source_mode` ENUM('Existing', 'New PO') NOT NULL DEFAULT 'Existing'");
    }
};
