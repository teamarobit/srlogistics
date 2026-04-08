<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Superadmin',
                'slug' => 'superadmin',
                'is_deletable' => 'No',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'is_deletable' => 'No',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Employee',
                'slug' => 'employee',
                'is_deletable' => 'Yes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HO User (Headoffice)',
                'slug' => 'ho-user',
                'is_deletable' => 'Yes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Branch User',
                'slug' => 'branch-user',
                'is_deletable' => 'Yes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Driver Coordination Staff',
                'slug' => 'driver-coordination-staff',
                'is_deletable' => 'Yes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Accounts / Finance User',
                'slug' => 'accounts-finance-user',
                'is_deletable' => 'Yes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Service Manager',
                'slug' => 'service-manager',
                'is_deletable' => 'Yes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}

