<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class PTStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 177,
'name' => 'Lisbon',
'iso2' => '11'
],[
'country_id' => 177,
'name' => 'Bragança',
'iso2' => '04'
],[
'country_id' => 177,
'name' => 'Beja',
'iso2' => '02'
],[
'country_id' => 177,
'name' => 'Madeira',
'iso2' => '30'
],[
'country_id' => 177,
'name' => 'Portalegre',
'iso2' => '12'
],[
'country_id' => 177,
'name' => 'Açores',
'iso2' => '20'
],[
'country_id' => 177,
'name' => 'Vila Real',
'iso2' => '17'
],[
'country_id' => 177,
'name' => 'Aveiro',
'iso2' => '01'
],[
'country_id' => 177,
'name' => 'Évora',
'iso2' => '07'
],[
'country_id' => 177,
'name' => 'Viseu',
'iso2' => '18'
],[
'country_id' => 177,
'name' => 'Santarém',
'iso2' => '14'
],[
'country_id' => 177,
'name' => 'Faro',
'iso2' => '08'
],[
'country_id' => 177,
'name' => 'Leiria',
'iso2' => '10'
],[
'country_id' => 177,
'name' => 'Castelo Branco',
'iso2' => '05'
],[
'country_id' => 177,
'name' => 'Setúbal',
'iso2' => '15'
],[
'country_id' => 177,
'name' => 'Porto',
'iso2' => '13'
],[
'country_id' => 177,
'name' => 'Braga',
'iso2' => '03'
],[
'country_id' => 177,
'name' => 'Viana do Castelo',
'iso2' => '16'
],[
'country_id' => 177,
'name' => 'Coimbra',
'iso2' => '06'
],[
'country_id' => 177,
'name' => 'Guarda',
'iso2' => '09'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
