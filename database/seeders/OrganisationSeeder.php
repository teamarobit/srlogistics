<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrganisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organisations = [
            [
                'name' => 'SR Logistics',
                'user_id' => 1,
                'contact_person_name' => 'SR Logistics',
                'contact_person_phone_prefix' => '+91',
                'contact_person_phone_no' => '99999999',
                'status' => 'Active',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('organisations')->insert($organisations);
    }
}
