<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Makes tyres.contact_id nullable so that Direct Fitment allocations
 * (where the tyre is bought and fitted on-site with no pre-registered vendor)
 * can create a Tyre record without a contact_id.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tyres', function (Blueprint $table) {
            $table->bigInteger('contact_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        // NOTE: reversing to NOT NULL will fail if any rows already have NULL contact_id.
        // Only reverse this if no Direct Fitment tyres exist.
        Schema::table('tyres', function (Blueprint $table) {
            $table->bigInteger('contact_id')->nullable(false)->change();
        });
    }
};
