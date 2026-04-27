<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Tyreposition;

class TyrepositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['code' => 'C1',  'description' => 'Conductor 1', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'D1',  'description' => 'Driver 1', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'Ci2', 'description' => 'Conductor Inside 2', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'Co3', 'description' => 'Conductor Outside 3', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'Di2', 'description' => 'Driver Inside 2', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'Do3', 'description' => 'Driver Outside 3', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            
            // More than 6 wheel
            ['code' => 'Ci4', 'description' => 'Conductor Inside 4', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'Co5', 'description' => 'Conductor Outside 5', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'Di4', 'description' => 'Driver Inside 4', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'Do5', 'description' => 'Driver Outside 5', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],

            // 12-wheel — trailing single axle (one tyre per side, no inner/outer)
            ['code' => 'C6',  'description' => 'Conductor 6', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'D6',  'description' => 'Driver 6',    'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],

            // Stepney
            ['code' => 'S1',  'description' => 'Stepney 1', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
        ];
        
        Tyreposition::insert($data);
    }
}
