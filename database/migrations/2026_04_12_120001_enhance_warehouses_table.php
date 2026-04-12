<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Enhance the warehouses table with code, location, contact, and audit columns.
 * Existing `warehouses` table was created 2026-04-07 with just name + status.
 * BA CIAA approved — April 2026.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->string('warehouse_code', 30)->unique()->nullable()
                  ->after('id')
                  ->comment('e.g. WH-HYD-001');

            $table->string('city')->nullable()->after('name');
            $table->string('state')->nullable()->after('city');
            $table->text('address')->nullable()->after('state');
            $table->string('pincode', 10)->nullable()->after('address');

            $table->string('manager_name')->nullable()->after('pincode');
            $table->string('contact_phone', 20)->nullable()->after('manager_name');

            $table->text('notes')->nullable()->after('contact_phone');

            $table->bigInteger('organisation_id')->nullable()->after('id')
                  ->comment('FK → organisations.id');

            $table->bigInteger('created_by')->nullable()->after('notes');
            $table->bigInteger('updated_by')->nullable()->after('created_by');
            $table->bigInteger('deleted_by')->nullable()->after('updated_by');
        });

        // Add softDeletes column (deleted_at) if not already present
        if (!Schema::hasColumn('warehouses', 'deleted_at')) {
            Schema::table('warehouses', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->dropColumn([
                'organisation_id', 'warehouse_code', 'city', 'state',
                'address', 'pincode', 'manager_name', 'contact_phone',
                'notes', 'created_by', 'updated_by', 'deleted_by',
            ]);
            if (Schema::hasColumn('warehouses', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
