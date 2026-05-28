<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add battery-tagging columns to vehiclebatteries.
     * Existing columns: id, vehicle_id, battery_model_name, battery_capacity,
     *   battery_brand, battery_price, battery_serial_number, purchase_date,
     *   issue_date, warranty_months, fixed_life_months, created/updated/deleted_by,
     *   timestamps, softDeletes.
     */
    public function up(): void
    {
        Schema::table('vehiclebatteries', function (Blueprint $table) {
            // Battery identity extras
            $table->string('battery_model', 100)->nullable()->after('battery_model_name');
            $table->string('battery_voltage', 10)->nullable()->after('battery_capacity');
            $table->enum('battery_condition', ['New', 'Used', 'Replaced Under Warranty'])
                  ->default('New')->after('battery_voltage');

            // RAG status (Red / Yellow / Green)
            $table->enum('rag_status', ['Green', 'Yellow', 'Red'])->default('Green')->after('battery_condition');

            // Fitment tracking
            $table->date('fitment_date')->nullable()->after('issue_date');
            $table->unsignedInteger('battery_actual_km')->default(0)->after('fitment_date');
            $table->unsignedSmallInteger('battery_life_fixed')->nullable()->after('battery_actual_km');
            $table->unsignedSmallInteger('battery_actual_run_months')->default(0)->after('battery_life_fixed');

            // Active / Inactive tagging status (max 2 Active per vehicle)
            $table->enum('status', ['Active', 'Inactive'])->default('Active')->after('battery_actual_run_months');

            // Multi-tenancy
            $table->bigInteger('organisation_id')->default(1)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('vehiclebatteries', function (Blueprint $table) {
            $table->dropColumn([
                'battery_model',
                'battery_voltage',
                'battery_condition',
                'rag_status',
                'fitment_date',
                'battery_actual_km',
                'battery_life_fixed',
                'battery_actual_run_months',
                'status',
                'organisation_id',
            ]);
        });
    }
};
