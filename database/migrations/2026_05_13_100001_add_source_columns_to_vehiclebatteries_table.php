<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add battery source tracking columns to vehiclebatteries + vehiclebatterylogs.
     *
     * New columns:
     *   battery_source       — 'SR Warehouse' | 'Direct Fitment'
     *   km_at_fitment        — odometer reading at time of fitment
     *   warehouse_battery_id — FK → batteries.id (set when source = SR Warehouse)
     */
    public function up(): void
    {
        Schema::table('vehiclebatteries', function (Blueprint $table) {
            $table->enum('battery_source', ['SR Warehouse', 'Direct Fitment'])
                  ->default('Direct Fitment')
                  ->after('status');

            $table->unsignedInteger('km_at_fitment')
                  ->default(0)
                  ->after('battery_source');

            // Signed bigint — no unsignedBigInteger() per SD project rules (signed FK pair)
            $table->bigInteger('warehouse_battery_id')
                  ->nullable()
                  ->after('km_at_fitment')
                  ->comment('FK → batteries.id, set when battery_source = SR Warehouse');
        });

        Schema::table('vehiclebatterylogs', function (Blueprint $table) {
            $table->enum('battery_source', ['SR Warehouse', 'Direct Fitment'])
                  ->nullable()
                  ->after('notes');

            $table->unsignedInteger('km_at_fitment')
                  ->default(0)
                  ->after('battery_source');

            $table->bigInteger('warehouse_battery_id')
                  ->nullable()
                  ->after('km_at_fitment')
                  ->comment('FK → batteries.id');
        });
    }

    public function down(): void
    {
        Schema::table('vehiclebatteries', function (Blueprint $table) {
            $table->dropColumn(['battery_source', 'km_at_fitment', 'warehouse_battery_id']);
        });

        Schema::table('vehiclebatterylogs', function (Blueprint $table) {
            $table->dropColumn(['battery_source', 'km_at_fitment', 'warehouse_battery_id']);
        });
    }
};
