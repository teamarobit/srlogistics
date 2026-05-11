<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds action-tracking columns to tyrelogs so Take Action modal events
 * (Alignment, Replace, Rotate) can each write a structured log row.
 *
 * All new columns are nullable to remain backward-compatible with existing
 * log rows that were inserted by the Tyre create/edit flow (which never had
 * these fields).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tyrelogs', function (Blueprint $table) {
            // What type of action was logged
            $table->enum('action_type', [
                'Fitment', 'Replacement', 'Rotation', 'Alignment',
                'Warranty Claim', 'Re-thread', 'Scrap', 'Yet to Decide', 'Other'
            ])->nullable()->after('tyre_id');

            // Date and odometer reading at the time of the action
            $table->date('action_date')->nullable()->after('action_type');
            $table->decimal('action_km', 12, 2)->nullable()->after('action_date');

            // Which vehicle / mapping this action is tied to
            $table->bigInteger('vehicle_id')->nullable()->comment('FK → vehicles.id')->after('action_km');
            $table->bigInteger('mapping_id')->nullable()->comment('FK → vehicletyremappings.id')->after('vehicle_id');

            // Free-text notes for the action (destination, reason, etc.)
            $table->text('action_notes')->nullable()->after('mapping_id');
        });
    }

    public function down(): void
    {
        Schema::table('tyrelogs', function (Blueprint $table) {
            $table->dropColumn([
                'action_type', 'action_date', 'action_km',
                'vehicle_id', 'mapping_id', 'action_notes',
            ]);
        });
    }
};
