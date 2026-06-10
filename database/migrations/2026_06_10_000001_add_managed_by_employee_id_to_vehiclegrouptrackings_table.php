<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vehiclegrouptrackings', function (Blueprint $table) {
            // FK → contacts.id (employee master). No FK constraint to avoid
            // MySQL 8 signed/unsigned mismatch; integrity enforced via Eloquent
            // + exists: validation. Matches contacts.id (unsigned bigint).
            $table->unsignedBigInteger('managed_by_employee_id')
                  ->nullable()
                  ->after('vehicle_group_id')
                  ->comment('FK → contacts.id (employee master)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehiclegrouptrackings', function (Blueprint $table) {
            $table->dropColumn('managed_by_employee_id');
        });
    }
};
