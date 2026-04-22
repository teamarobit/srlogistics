<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add warehouse_type, location_name, and storage_type columns to warehouses table.
 * BA SSA spec approved — Warehouse Master v1.0, April 2026.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('warehouses', function (Blueprint $table) {
            if (! Schema::hasColumn('warehouses', 'warehouse_type')) {
                $table->enum('warehouse_type', ['Central', 'Regional', 'Site/Yard'])
                      ->nullable()
                      ->after('name')
                      ->comment('Type of warehouse');
            }

            if (! Schema::hasColumn('warehouses', 'location_name')) {
                $table->string('location_name', 150)
                      ->nullable()
                      ->after('address')
                      ->comment('Landmark / area name');
            }

            if (! Schema::hasColumn('warehouses', 'storage_type')) {
                $table->enum('storage_type', ['Rack', 'Floor', 'Open Yard'])
                      ->nullable()
                      ->after('contact_phone')
                      ->comment('Physical storage arrangement');
            }
        });
    }

    public function down(): void
    {
        Schema::table('warehouses', function (Blueprint $table) {
            foreach (['warehouse_type', 'location_name', 'storage_type'] as $col) {
                if (Schema::hasColumn('warehouses', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
