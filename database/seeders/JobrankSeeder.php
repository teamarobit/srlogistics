<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JobrankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // DB::table('jobranks')->insert([
        //     ['name' => 'Entry Level', 'created_at' => $now, 'updated_at' => $now],
        //     ['name' => 'Associate', 'created_at' => $now, 'updated_at' => $now],
        //     ['name' => 'Manager', 'created_at' => $now, 'updated_at' => $now],
        // ]);
    }
}