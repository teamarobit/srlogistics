<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add organisation_id to gpsproviders (multi-tenant scope) per RULE 11.
     *
     * Signed bigInteger to match legacy convention (legacy tables use bigInteger('id', true),
     * not the unsigned $table->id()).
     */
    public function up(): void
    {
        Schema::table('gpsproviders', function (Blueprint $table) {
            $table->bigInteger('organisation_id')->default(1)->after('id')
                  ->comment('FK -> organisations.id');
            $table->index('organisation_id');
        });

        // Backfill any existing rows just to be safe (default already covers new inserts).
        DB::table('gpsproviders')->whereNull('organisation_id')->update(['organisation_id' => 1]);
    }

    public function down(): void
    {
        Schema::table('gpsproviders', function (Blueprint $table) {
            $table->dropIndex(['organisation_id']);
            $table->dropColumn('organisation_id');
        });
    }
};
