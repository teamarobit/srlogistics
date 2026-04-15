<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fleetstatus;

class FleetstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['organisation_id' => 1, 'name' => 'On the Way',        'color_class' => 'bg-success'],
            ['organisation_id' => 1, 'name' => 'Waiting to Load',   'color_class' => 'cng_c'],
            ['organisation_id' => 1, 'name' => 'Loading',           'color_class' => 'bg-info'],
            ['organisation_id' => 1, 'name' => 'Waiting to Unload', 'color_class' => 'cng_c'],
            ['organisation_id' => 1, 'name' => 'Unloading',         'color_class' => 'petrol_c'],
            ['organisation_id' => 1, 'name' => 'Maintenance',       'color_class' => 'bg-warning'],
            ['organisation_id' => 1, 'name' => 'Empty',             'color_class' => 'bg-empty'],
            ['organisation_id' => 1, 'name' => 'Inactive',          'color_class' => 'bg-secondary'],
            ['organisation_id' => 1, 'name' => 'Without Driver',    'color_class' => 'bg-dark'],
            ['organisation_id' => 1, 'name' => 'SOS',               'color_class' => 'bg-danger'],
        ];

        foreach ($statuses as $status) {
            Fleetstatus::create($status);
        }
    }
}
