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

            // 14/16-wheel — rear dual axle 3
            ['code' => 'Ci6', 'description' => 'Conductor Inside 6',  'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'Co7', 'description' => 'Conductor Outside 7', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'Di6', 'description' => 'Driver Inside 6',     'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'Do7', 'description' => 'Driver Outside 7',    'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],

            // 16-wheel — trailing single after 3 dual axles
            ['code' => 'C8',  'description' => 'Conductor 8', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'D8',  'description' => 'Driver 8',    'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],

            // 18/20-wheel — rear dual axle 4
            ['code' => 'Ci8',  'description' => 'Conductor Inside 8',   'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'Co9',  'description' => 'Conductor Outside 9',  'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'Di8',  'description' => 'Driver Inside 8',      'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'Do9',  'description' => 'Driver Outside 9',     'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],

            // 20-wheel — trailing single after 4 dual axles
            ['code' => 'C10', 'description' => 'Conductor 10', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'D10', 'description' => 'Driver 10',    'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],

            // 22-wheel — rear dual axle 5
            ['code' => 'Ci10', 'description' => 'Conductor Inside 10',  'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'Co11', 'description' => 'Conductor Outside 11', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'Di10', 'description' => 'Driver Inside 10',     'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'Do11', 'description' => 'Driver Outside 11',    'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],

            // Stepney
            ['code' => 'S1',  'description' => 'Stepney 1', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
        ];
        
        Tyreposition::insert($data);
    }
}
