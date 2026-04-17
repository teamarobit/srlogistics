<?php

use Illuminate\Database\Migrations\Migration;

/**
 * SD-2 COMPLIANCE: This migration previously contained seed data (violation).
 * Seed data has been moved to database/seeders/InsurancecompanySeeder.php
 * Run: php artisan db:seed --class=InsurancecompanySeeder
 *
 * This file is kept as a no-op to preserve migration history.
 */
return new class extends Migration
{
    public function up(): void
    {
        // No-op: seed data belongs in InsurancecompanySeeder, not migrations.
    }

    public function down(): void
    {
        // No-op.
    }
};
