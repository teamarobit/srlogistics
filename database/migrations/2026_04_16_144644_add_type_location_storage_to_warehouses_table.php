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
            $table->enum('warehouse_type', ['Central', 'Regional', 'Site/Yard'])
                  ->nullable()
                  ->after('name')
                  ->comment('Type of warehouse');

            $table->string('location_name', 150)
                  ->nullable()
                  ->after('address')
                  ->comment('Landmark / area name');

            $table->enum('storage_type', ['Rack', 'Floor', 'Open Yard'])
                  ->nullable()
                  ->after('contact_phone')
                  ->comment('Physical storage arrangement');
        });
    }

    public function down(): void
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->dropColumn(['warehouse_type', 'location_name', 'storage_type']);
        });
    }
};
