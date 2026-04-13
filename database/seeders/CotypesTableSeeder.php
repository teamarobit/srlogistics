<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CotypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('cotypes')->insert([
            ['name' => 'Customer', 'slug' => 'customer', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Load Vendor (Broker)', 'slug' => 'loadvendor', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Employee', 'slug' => 'employee', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Driver', 'slug' => 'driver', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Vehicle Vendor', 'slug' => 'vehiclevendor', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Tyre Vendor', 'slug' => 'tyrevendor', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Battery Vendor', 'slug' => 'batteryvendor', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Spare Part Vendor', 'slug' => 'sparevendor', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Insurance Provider', 'slug' => 'insuranceprovider', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
