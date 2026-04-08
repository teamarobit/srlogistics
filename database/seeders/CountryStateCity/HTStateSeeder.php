<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class HTStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 95,
'name' => 'Nord',
'iso2' => 'ND'
],[
'country_id' => 95,
'name' => 'Nippes',
'iso2' => 'NI'
],[
'country_id' => 95,
'name' => 'Grand Anse',
'iso2' => 'GA'
],[
'country_id' => 95,
'name' => 'Ouest',
'iso2' => 'OU'
],[
'country_id' => 95,
'name' => 'Nord-Est',
'iso2' => 'NE'
],[
'country_id' => 95,
'name' => 'Sud',
'iso2' => 'SD'
],[
'country_id' => 95,
'name' => 'Artibonite',
'iso2' => 'AR'
],[
'country_id' => 95,
'name' => 'Sud-Est',
'iso2' => 'SE'
],[
'country_id' => 95,
'name' => 'Centre',
'iso2' => 'CE'
],[
'country_id' => 95,
'name' => 'Nord-Ouest',
'iso2' => 'NO'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
