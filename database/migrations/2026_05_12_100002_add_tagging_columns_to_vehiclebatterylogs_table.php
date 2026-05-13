<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add action / tagging columns to vehiclebatterylogs.
     */
    public function up(): void
    {
        Schema::table('vehiclebatterylogs', function (Blueprint $table) {
            $table->string('battery_model', 100)->nullable()->after('battery_model_name');
            $table->string('battery_voltage', 10)->nullable()->after('battery_capacity');
            $table->enum('battery_condition', ['New', 'Used', 'Replaced Under Warranty'])
                  ->nullable()->after('battery_voltage');

            $table->enum('rag_status', ['Green', 'Yellow', 'Red'])->nullable()->after('battery_condition');

            $table->date('fitment_date')->nullable()->after('issue_date');
            $table->unsignedInteger('battery_actual_km')->default(0)->after('fitment_date');
            $table->unsignedSmallInteger('battery_life_fixed')->nullable()->after('battery_actual_km');
            $table->unsignedSmallInteger('battery_actual_run_months')->default(0)->after('battery_life_fixed');

            $table->enum('action', ['Tagged', 'Removed', 'Updated'])->default('Tagged')->after('battery_actual_run_months');
            $table->text('notes')->nullable()->after('action');

            $table->bigInteger('organisation_id')->default(1)->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('vehiclebatterylogs', function (Blueprint $table) {
            $table->dropColumn([
                'battery_model',
                'battery_voltage',
                'battery_condition',
                'rag_status',
                'fitment_date',
                'battery_actual_km',
                'battery_life_fixed',
                'battery_actual_run_months',
                'action',
                'notes',
                'organisation_id',
            ]);
        });
    }
};
