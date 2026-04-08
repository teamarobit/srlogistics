<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class AFStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
                    [
                    'country_id' => 1,
                    'name' => "Ghazni",
                    'iso2' => "GHA"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Badghis",
                    'iso2' => "BDG"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Bamyan",
                    'iso2' => "BAM"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Helmand",
                    'iso2' => "HEL"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Zabul",
                    'iso2' => "ZAB"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Baghlan",
                    'iso2' => "BGL"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Kunar",
                    'iso2' => "KNR"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Paktika",
                    'iso2' => "PKA"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Khost",
                    'iso2' => "KHO"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Kapisa",
                    'iso2' => "KAP"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Nuristan",
                    'iso2' => "NUR"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Panjshir",
                    'iso2' => "PAN"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Nangarhar",
                    'iso2' => "NAN"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Samangan",
                    'iso2' => "SAM"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Balkh",
                    'iso2' => "BAL"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Sar-e Pol",
                    'iso2' => "SAR"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Jowzjan",
                    'iso2' => "JOW"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Herat",
                    'iso2' => "HER"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Ghōr",
                    'iso2' => "GHO"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Faryab",
                    'iso2' => "FYB"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Kandahar",
                    'iso2' => "KAN"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Laghman",
                    'iso2' => "LAG"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Daykundi",
                    'iso2' => "DAY"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Takhar",
                    'iso2' => "TAK"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Paktia",
                    'iso2' => "PIA"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Parwan",
                    'iso2' => "PAR"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Nimruz",
                    'iso2' => "NIM"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Logar",
                    'iso2' => "LOG"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Urozgan",
                    'iso2' => "URU"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Farah",
                    'iso2' => "FRA"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Kunduz Province",
                    'iso2' => "KDZ"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Badakhshan",
                    'iso2' => "BDS"
                    ],
                    [
                    'country_id' => 1,
                    'name' => "Kabul",
                    'iso2' => "KAB"
                    ]
                ];
                        
        foreach($datas as $data){
            State::create($data);
        }
        
    }
}
