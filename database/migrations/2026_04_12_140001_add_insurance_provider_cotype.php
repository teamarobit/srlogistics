<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Insert Insurance Provider cotype (id = 9, slug = insuranceprovider).
 */
return new class extends Migration
{
    public function up(): void
    {
        // $exists = DB::table('cotypes')->where('slug', 'insuranceprovider')->exists();
        // if (!$exists) {
        //     DB::table('cotypes')->insert([
        //         'name'       => 'Insurance Provider',
        //         'slug'       => 'insuranceprovider',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ]);
        // }
    }

    public function down(): void
    {
        // DB::table('cotypes')->where('slug', 'insuranceprovider')->delete();
    }
};
