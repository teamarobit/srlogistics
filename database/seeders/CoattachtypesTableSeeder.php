<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CoattachtypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('coattachtypes')->insert([
            ['name' => 'Aadhaar Card', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Voter Card', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Pan Card', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Electricity Bill', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Driving License', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Passport', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'TDS Declaration', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Contract Copy', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
