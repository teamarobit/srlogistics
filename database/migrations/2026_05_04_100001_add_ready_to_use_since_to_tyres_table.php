<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds ready_to_use_since column to tyres table.
 * Required by Accordion 2 "Ready To Use" on the Tyre Details screen.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tyres', function (Blueprint $table) {
            if (! Schema::hasColumn('tyres', 'ready_to_use_since')) {
                $table->date('ready_to_use_since')
                      ->nullable()
                      ->after('damage_reason')
                      ->comment('Date when tyre was marked as Ready to Use (Accordion 2)');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tyres', function (Blueprint $table) {
            if (Schema::hasColumn('tyres', 'ready_to_use_since')) {
                $table->dropColumn('ready_to_use_since');
            }
        });
    }
};
