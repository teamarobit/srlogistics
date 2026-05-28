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
     *
     * Schema::hasColumn guards make this safe to run even if a partial apply occurred.
     */
    public function up(): void
    {
        Schema::table('vehiclebatteries', function (Blueprint $table) {
            if (! Schema::hasColumn('vehiclebatteries', 'battery_source')) {
                $table->enum('battery_source', ['SR Warehouse', 'Direct Fitment'])
                      ->default('Direct Fitment')
                      ->after('status');
            }

            if (! Schema::hasColumn('vehiclebatteries', 'km_at_fitment')) {
                $table->unsignedInteger('km_at_fitment')
                      ->default(0)
                      ->after('battery_source');
            }

            if (! Schema::hasColumn('vehiclebatteries', 'warehouse_battery_id')) {
                // Signed bigint — no unsignedBigInteger() per SD project rules (signed FK pair)
                $table->bigInteger('warehouse_battery_id')
                      ->nullable()
                      ->after('km_at_fitment')
                      ->comment('FK → batteries.id, set when battery_source = SR Warehouse');
            }
        });

        Schema::table('vehiclebatterylogs', function (Blueprint $table) {
            if (! Schema::hasColumn('vehiclebatterylogs', 'battery_source')) {
                $table->enum('battery_source', ['SR Warehouse', 'Direct Fitment'])
                      ->nullable()
                      ->after('notes');
            }

            if (! Schema::hasColumn('vehiclebatterylogs', 'km_at_fitment')) {
                $table->unsignedInteger('km_at_fitment')
                      ->default(0)
                      ->after('battery_source');
            }

            if (! Schema::hasColumn('vehiclebatterylogs', 'warehouse_battery_id')) {
                $table->bigInteger('warehouse_battery_id')
                      ->nullable()
                      ->after('km_at_fitment')
                      ->comment('FK → batteries.id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('vehiclebatteries', function (Blueprint $table) {
            $columns = array_filter(
                ['battery_source', 'km_at_fitment', 'warehouse_battery_id'],
                fn ($col) => Schema::hasColumn('vehiclebatteries', $col)
            );
            if ($columns) {
                $table->dropColumn(array_values($columns));
            }
        });

        Schema::table('vehiclebatterylogs', function (Blueprint $table) {
            $columns = array_filter(
                ['battery_source', 'km_at_fitment', 'warehouse_battery_id'],
                fn ($col) => Schema::hasColumn('vehiclebatterylogs', $col)
            );
            if ($columns) {
                $table->dropColumn(array_values($columns));
            }
        });
    }
};
