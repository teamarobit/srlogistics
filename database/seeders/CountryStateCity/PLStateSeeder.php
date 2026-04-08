<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class PLStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 176,
'name' => 'Opole Voivodeship',
'iso2' => 'OP'
],[
'country_id' => 176,
'name' => 'Silesian Voivodeship',
'iso2' => 'SL'
],[
'country_id' => 176,
'name' => 'Pomeranian Voivodeship',
'iso2' => 'PM'
],[
'country_id' => 176,
'name' => 'Kuyavian-Pomeranian Voivodeship',
'iso2' => 'KP'
],[
'country_id' => 176,
'name' => 'Podkarpackie Voivodeship',
'iso2' => 'PK'
],[
'country_id' => 176,
'name' => 'Warmian-Masurian Voivodeship',
'iso2' => 'WN'
],[
'country_id' => 176,
'name' => 'Lower Silesian Voivodeship',
'iso2' => 'DS'
],[
'country_id' => 176,
'name' => 'Świętokrzyskie Voivodeship',
'iso2' => 'SK'
],[
'country_id' => 176,
'name' => 'Lubusz Voivodeship',
'iso2' => 'LB'
],[
'country_id' => 176,
'name' => 'Podlaskie Voivodeship',
'iso2' => 'PD'
],[
'country_id' => 176,
'name' => 'West Pomeranian Voivodeship',
'iso2' => 'ZP'
],[
'country_id' => 176,
'name' => 'Greater Poland Voivodeship',
'iso2' => 'WP'
],[
'country_id' => 176,
'name' => 'Lesser Poland Voivodeship',
'iso2' => 'MA'
],[
'country_id' => 176,
'name' => 'Łódź Voivodeship',
'iso2' => 'LD'
],[
'country_id' => 176,
'name' => 'Masovian Voivodeship',
'iso2' => 'MZ'
],[
'country_id' => 176,
'name' => 'Lublin Voivodeship',
'iso2' => 'LU'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
