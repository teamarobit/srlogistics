<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GsttreatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('gsttreats')->insert([
            ['name' => 'Registered', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Unregistered', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
