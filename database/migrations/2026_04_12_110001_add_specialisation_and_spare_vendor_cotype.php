<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * 1. Add `specialisation` column to contacts table.
 * 2. Insert Spare Part Vendor cotype (id = 8, slug = sparevendor).
 */
return new class extends Migration
{
    public function up(): void
    {
        // 1 — Add specialisation to contacts
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('specialisation', 500)->nullable()
                  ->after('company_name')
                  ->comment('Comma-separated specialisations e.g. Engine,Brakes,Filters');
        });

        // 2 — Insert spare vendor cotype if not already present
        $exists = DB::table('cotypes')->where('slug', 'sparevendor')->exists();
        if (!$exists) {
            DB::table('cotypes')->insert([
                'name'       => 'Spare Part Vendor',
                'slug'       => 'sparevendor',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('specialisation');
        });

        DB::table('cotypes')->where('slug', 'sparevendor')->delete();
    }
};
