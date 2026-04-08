<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('religions')->insert([
            ['name' => 'Hindu', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sikh', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Christian', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Buddhist', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Jain', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Parsi', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Muslim', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
