<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class GYStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 94,
'name' => 'Cuyuni-Mazaruni',
'iso2' => 'CU'
],[
'country_id' => 94,
'name' => 'Potaro-Siparuni',
'iso2' => 'PT'
],[
'country_id' => 94,
'name' => 'Mahaica-Berbice',
'iso2' => 'MA'
],[
'country_id' => 94,
'name' => 'Upper Demerara-Berbice',
'iso2' => 'UD'
],[
'country_id' => 94,
'name' => 'Barima-Waini',
'iso2' => 'BA'
],[
'country_id' => 94,
'name' => 'Pomeroon-Supenaam',
'iso2' => 'PM'
],[
'country_id' => 94,
'name' => 'East Berbice-Corentyne',
'iso2' => 'EB'
],[
'country_id' => 94,
'name' => 'Demerara-Mahaica',
'iso2' => 'DE'
],[
'country_id' => 94,
'name' => 'Essequibo Islands-West Demerara',
'iso2' => 'ES'
],[
'country_id' => 94,
'name' => 'Upper Takutu-Upper Essequibo',
'iso2' => 'UT'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
