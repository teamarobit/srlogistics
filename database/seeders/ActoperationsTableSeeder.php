<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActoperationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('actoperations')->insert([
            ['name' => 'Login', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Logout', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Create', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Update', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Read', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Delete', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Export', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
