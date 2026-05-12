<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Refactor workshops table:
 * - Add state_id (FK → states.id — bigInteger to match legacy PK style)
 * - Add city_id  (FK → cities.id — bigInteger; city resolved/created in controller)
 * - Drop old free-text state / city string columns
 *
 * BA SCR-WS-M-001 approved — Workshop Master State/City FK — April 2026.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Step 1 — add new FK columns
        Schema::table('workshops', function (Blueprint $table) {
            $table->bigInteger('state_id')->nullable()->after('brand')
                  ->comment('FK → states.id (country_id=101 India)');

            $table->bigInteger('city_id')->nullable()->after('state_id')
                  ->comment('FK → cities.id — resolved/created by controller');
        });

        // Step 2 — drop old free-text columns (separate call — MySQL restriction)
        Schema::table('workshops', function (Blueprint $table) {
            if (Schema::hasColumn('workshops', 'state')) {
                $table->dropColumn('state');
            }
            if (Schema::hasColumn('workshops', 'city')) {
                $table->dropColumn('city');
            }
        });
    }

    public function down(): void
    {
        Schema::table('workshops', function (Blueprint $table) {
            if (Schema::hasColumn('workshops', 'state_id')) {
                $table->dropColumn('state_id');
            }
            if (Schema::hasColumn('workshops', 'city_id')) {
                $table->dropColumn('city_id');
            }
            $table->string('state')->nullable()->after('brand');
            $table->string('city')->nullable()->after('state');
        });
    }
};
