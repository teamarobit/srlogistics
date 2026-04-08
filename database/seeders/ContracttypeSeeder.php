<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ContracttypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $now = Carbon::now();

        $data = [
            ['id' => 1, 'name' => 'Monthly', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => 'Quarterly', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'name' => 'Half Yearly', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'name' => 'Yearly', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'name' => 'Trip Wise', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 6, 'name' => 'Life Time', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('contracttypes')->insert($data);
    }
}
