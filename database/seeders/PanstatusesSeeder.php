<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PanstatusesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('panstatuses')->insert([
            [
                'id' => 1,
                'organisation_id' => 1,
                'name' => 'Application is received',
                'created_by' => 2,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => '2026-03-02 08:38:17',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'organisation_id' => 1,
                'name' => 'Application is under process',
                'created_by' => 2,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => '2026-03-02 08:38:34',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'organisation_id' => 1,
                'name' => 'Application is approved',
                'created_by' => 2,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => '2026-03-02 08:38:46',
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'organisation_id' => 1,
                'name' => 'Application rejected',
                'created_by' => 2,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => '2026-03-02 08:38:56',
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}