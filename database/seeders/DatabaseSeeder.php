<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Database\Seeders\CountryStateCity\CountryStateCitySeeder;
use Database\Seeders\ActmodelsTableSeeder;
use Database\Seeders\ActoperationsTableSeeder;
use Database\Seeders\GsttreatsTableSeeder;
use Database\Seeders\CotypesTableSeeder;
use Database\Seeders\CustomerabouttypesSeeder;
use Database\Seeders\CoattachtypesTableSeeder;
use Database\Seeders\ContracttypeSeeder;
use Database\Seeders\OrganisationSeeder;
use Database\Seeders\OrganisationuserSeeder;
use Database\Seeders\JobrankSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TyrepositionSeeder;
use Database\Seeders\TyreWarehouseSeeder;

use Database\Seeders\ReligionSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call([   
                        ActmodelsTableSeeder::class,
                        ActoperationsTableSeeder::class,
                        AttachmentTypeSeeder::class,
                        BankSeeder::class,
                        GsttreatsTableSeeder::class,
                        CotypesTableSeeder::class,
                        CustomerabouttypesSeeder::class,
                        CoattachtypesTableSeeder::class,
                        ContracttypeSeeder::class,
                        OrganisationSeeder::class,
                        OrganisationuserSeeder::class,
                        UserSeeder::class,
                        RoleSeeder::class,
                        CountryStateCitySeeder::class,
                        ReligionSeeder::class,
                        JobrankSeeder::class,
                        TyrepositionSeeder::class,
                        InsurancecompanySeeder::class,
                        InsuranceProviderSeeder::class,
                        PanstatusesSeeder::class,
                        SparePartCategoriesSeeder::class,
                        SparePartsSeeder::class,
                        SpareVendorSeeder::class,
                        TestVehicleSeeder::class,
                        WarehouseSeeder::class,
                        FleetstatusSeeder::class,
                    ]);
    }
}



