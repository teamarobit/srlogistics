<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add battery_position and km_at_removal to vehiclebatteries.
     *
     * battery_position — where on the vehicle the battery is installed (e.g. Primary, Secondary)
     * km_at_removal    — vehicle odometer reading at the time the battery was removed
     */
    public function up(): void
    {
        Schema::table('vehiclebatteries', function (Blueprint $table) {
            if (! Schema::hasColumn('vehiclebatteries', 'battery_position')) {
                $table->string('battery_position', 100)
                      ->nullable()
                      ->after('vehicle_id');
            }

            if (! Schema::hasColumn('vehiclebatteries', 'km_at_removal')) {
                $table->unsignedInteger('km_at_removal')
                      ->nullable()
                      ->after('km_at_fitment');
            }
        });
    }

    public function down(): void
    {
        Schema::table('vehiclebatteries', function (Blueprint $table) {
            $columns = array_filter(
                ['battery_position', 'km_at_removal'],
                fn ($col) => Schema::hasColumn('vehiclebatteries', $col)
            );
            if ($columns) {
                $table->dropColumn(array_values($columns));
            }
        });
    }
};
