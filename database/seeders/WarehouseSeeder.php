<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'SR Warehouse', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
        ];
        
        Warehouse::insert($data);
    }
}
