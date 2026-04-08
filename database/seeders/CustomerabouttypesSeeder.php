<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerabouttypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customerabouttypes')->insert([
            ['id' => 1, 'name' => 'Electronic', 'created_at' => now()],
            ['id' => 2, 'name' => 'Automobile', 'created_at' => now()],
            ['id' => 3, 'name' => 'Cartoon Paper', 'created_at' => now()],
            ['id' => 4, 'name' => 'FMCG', 'created_at' => now()],
        ]);
    }
}
