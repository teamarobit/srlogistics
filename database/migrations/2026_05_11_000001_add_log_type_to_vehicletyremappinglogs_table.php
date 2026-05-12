<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add log_type to vehicletyremappinglogs.
     *
     * Values:
     *   'Replacement' — tyre replaced at this position (addTyreToPosition / logReplace)
     *   'Rotation'    — tyre rotated to/from this position (future logRotate method)
     *   null          — legacy rows created before this column existed (treated as Replacement in UI)
     *
     * Nullable so no default forces a value on existing rows; calling methods set it explicitly.
     */
    public function up(): void
    {
        Schema::table('vehicletyremappinglogs', function (Blueprint $table) {
            $table->enum('log_type', ['Rotation', 'Replacement'])
                  ->nullable()
                  ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('vehicletyremappinglogs', function (Blueprint $table) {
            $table->dropColumn('log_type');
        });
    }
};
