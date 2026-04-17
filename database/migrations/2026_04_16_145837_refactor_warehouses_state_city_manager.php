<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Refactor warehouses table:
 * - Add state_id (FK → states.id, signed bigInteger to match legacy PK)
 * - Add city as plain text (city name stored as-is; auto-inserted into cities if new)
 * - Add manager_contact_id (FK → contacts.id, cotype employee)
 * - Drop old text state / city columns (added in enhance migration Apr 12)
 * - Rename contact_phone → contact_number (fix from Apr 12 enhance)
 * BA SSA approved — Warehouse Master v1.1, April 2026.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('warehouses', function (Blueprint $table) {
            // State as FK (signed bigInteger — matches legacy bigIncrements PK)
            $table->bigInteger('state_id')->nullable()->after('address')
                  ->comment('FK → states.id');

            // City stored as name text (auto-inserted into cities table if new)
            $table->string('city_name', 100)->nullable()->after('state_id')
                  ->comment('City name — may or may not exist in cities table');

            // Manager from contacts (employee cotype)
            $table->bigInteger('manager_contact_id')->nullable()->after('city_name')
                  ->comment('FK → contacts.id (cotype: employee)');

            // Fix column name from Apr 12 migration
            if (Schema::hasColumn('warehouses', 'contact_phone') && !Schema::hasColumn('warehouses', 'contact_number')) {
                $table->renameColumn('contact_phone', 'contact_number');
            }
        });

        // Drop old text state/city columns added in Apr 12 migration
        Schema::table('warehouses', function (Blueprint $table) {
            if (Schema::hasColumn('warehouses', 'state')) {
                $table->dropColumn('state');
            }
            if (Schema::hasColumn('warehouses', 'city')) {
                $table->dropColumn('city');
            }
        });
    }

    public function down(): void
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->dropColumn(['state_id', 'city_name', 'manager_contact_id']);
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            if (Schema::hasColumn('warehouses', 'contact_number') && !Schema::hasColumn('warehouses', 'contact_phone')) {
                $table->renameColumn('contact_number', 'contact_phone');
            }
        });
    }
};
