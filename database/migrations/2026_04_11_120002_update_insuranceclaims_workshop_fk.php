<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Replace external_sc_id with workshop_id on insuranceclaims.
 *
 * Previously external_sc_id pointed at externalservicecentres.id.
 * After consolidation it points at workshops.id (ownership='External' or 'Own').
 * The settlement_mode column (Reimbursement / Cashless) is unchanged.
 * BA CIAA approved — April 2026.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('insuranceclaims', function (Blueprint $table) {
            // Rename the FK column
            $table->renameColumn('external_sc_id', 'workshop_id');
        });

        // Update the comment separately (renameColumn keeps old comment on some drivers)
        \DB::statement(
            "ALTER TABLE insuranceclaims
             MODIFY COLUMN workshop_id BIGINT NULL
             COMMENT 'FK → workshops.id — the workshop handling repairs (own or external)'"
        );
    }

    public function down(): void
    {
        Schema::table('insuranceclaims', function (Blueprint $table) {
            $table->renameColumn('workshop_id', 'external_sc_id');
        });
    }
};
