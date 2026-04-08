<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Organisationuser;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('12345678'); // same password for all
        
        $users = [
            [
                'name' => 'Parna',
                'email' => 'parna@srlogistics.co.in',
                'contact_id' => null,
                'organisation_id' => 1,
                'password' => $password,
                'email_verified_at' => null,
                'is_active' => 'Yes',
                'created_at' => '2025-07-18 06:18:42',
                'updated_at' => '2025-08-03 05:54:00',
            ],
            [
                'name' => 'Paramesh',
                'email' => 'paramesh@srlogistics.co.in',
                'contact_id' => null,
                'organisation_id' => 1,
                'password' => $password,
                'email_verified_at' => null,
                'is_active' => 'Yes',
                'created_at' => '2025-07-18 06:18:42',
                'updated_at' => '2025-08-03 05:54:00',
            ],
            [
                'name' => 'Archa',
                'email' => 'archa@srlogistics.co.in',
                'contact_id' => null,
                'organisation_id' => 1,
                'password' => $password,
                'email_verified_at' => null,
                'is_active' => 'Yes',
                'created_at' => '2025-07-18 06:18:42',
                'updated_at' => '2025-08-03 05:54:00',
            ],
            [
                'name' => 'Kankana',
                'email' => 'kankana@srlogistics.co.in',
                'contact_id' => null,
                'organisation_id' => 1,
                'password' => $password,
                'email_verified_at' => null,
                'is_active' => 'Yes',
                'created_at' => '2025-07-18 06:18:42',
                'updated_at' => '2025-08-03 05:54:00',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@srlogistics.co.in',
                'contact_id' => null,
                'organisation_id' => 1,
                'password' => $password,
                'email_verified_at' => null,
                'is_active' => 'Yes',
                'created_at' => '2025-07-18 06:18:42',
                'updated_at' => '2025-08-03 05:54:00',
            ],
            [
                'name' => 'Superadmin',
                'email' => 'superadmin@srlogistics.com',
                'contact_id' => null,
                'organisation_id' => 1,
                'password' => $password,
                'email_verified_at' => null,
                'is_active' => 'Yes',
                'created_at' => '2025-07-18 06:18:42',
                'updated_at' => '2025-08-03 05:54:00',
            ],
            [
                'name' => 'Guest User',
                'email' => 'user@srlogistics.com',
                'contact_id' => null,
                'organisation_id' => 1,
                'password' => $password,
                'email_verified_at' => null,
                'is_active' => 'Yes',
                'created_at' => '2025-07-18 06:18:42',
                'updated_at' => '2025-08-03 05:54:00',
            ],
            [
                'name' => 'Shreyashee',
                'email' => 'shreyashee@srlogistics.co.in',
                'contact_id' => null,
                'organisation_id' => 1,
                'password' => $password,
                'email_verified_at' => null,
                'is_active' => 'Yes',
                'created_at' => '2025-07-18 06:18:42',
                'updated_at' => '2025-08-03 05:54:00',
            ],
        ];
        
        
        DB::table('users')->insert($users);
        $users = User::get();
        if($users->count()){
            foreach($users as $user){
                $organisationuser = new Organisationuser();
                $organisationuser->user_id = $user->id;
                $organisationuser->organisation_id = 1;
                $organisationuser->save();
            }
        }
        
    }
}
