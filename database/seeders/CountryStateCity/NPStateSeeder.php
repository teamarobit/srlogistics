<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class NPStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 154,
'name' => 'Mid-Western Region',
'iso2' => '2'
],[
'country_id' => 154,
'name' => 'Western Region',
'iso2' => '3'
],[
'country_id' => 154,
'name' => 'Far-Western Development Region',
'iso2' => '5'
],[
'country_id' => 154,
'name' => 'Eastern Development Region',
'iso2' => '4'
],[
'country_id' => 154,
'name' => 'Mechi Zone',
'iso2' => 'ME'
],[
'country_id' => 154,
'name' => 'Bheri Zone',
'iso2' => 'BH'
],[
'country_id' => 154,
'name' => 'Kosi Zone',
'iso2' => 'KO'
],[
'country_id' => 154,
'name' => 'Central Region',
'iso2' => '1'
],[
'country_id' => 154,
'name' => 'Lumbini Zone',
'iso2' => 'LU'
],[
'country_id' => 154,
'name' => 'Narayani Zone',
'iso2' => 'NA'
],[
'country_id' => 154,
'name' => 'Janakpur Zone',
'iso2' => 'JA'
],[
'country_id' => 154,
'name' => 'Rapti Zone',
'iso2' => 'RA'
],[
'country_id' => 154,
'name' => 'Seti Zone',
'iso2' => 'SE'
],[
'country_id' => 154,
'name' => 'Karnali Zone',
'iso2' => 'KA'
],[
'country_id' => 154,
'name' => 'Dhaulagiri Zone',
'iso2' => 'DH'
],[
'country_id' => 154,
'name' => 'Gandaki Zone',
'iso2' => 'GA'
],[
'country_id' => 154,
'name' => 'Bagmati Zone',
'iso2' => 'BA'
],[
'country_id' => 154,
'name' => 'Mahakali Zone',
'iso2' => 'MA'
],[
'country_id' => 154,
'name' => 'Sagarmatha Zone',
'iso2' => 'SA'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
