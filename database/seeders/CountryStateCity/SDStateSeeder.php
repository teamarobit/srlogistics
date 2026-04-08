<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class SDStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 209,
'name' => 'White Nile',
'iso2' => 'NW'
],[
'country_id' => 209,
'name' => 'Red Sea',
'iso2' => 'RS'
],[
'country_id' => 209,
'name' => 'Khartoum',
'iso2' => 'KH'
],[
'country_id' => 209,
'name' => 'Sennar',
'iso2' => 'SI'
],[
'country_id' => 209,
'name' => 'South Kordofan',
'iso2' => 'KS'
],[
'country_id' => 209,
'name' => 'Kassala',
'iso2' => 'KA'
],[
'country_id' => 209,
'name' => 'Al Jazirah',
'iso2' => 'GZ'
],[
'country_id' => 209,
'name' => 'Al Qadarif',
'iso2' => 'GD'
],[
'country_id' => 209,
'name' => 'Blue Nile',
'iso2' => 'NB'
],[
'country_id' => 209,
'name' => 'West Darfur',
'iso2' => 'DW'
],[
'country_id' => 209,
'name' => 'West Kordofan',
'iso2' => 'GK'
],[
'country_id' => 209,
'name' => 'North Darfur',
'iso2' => 'DN'
],[
'country_id' => 209,
'name' => 'River Nile',
'iso2' => 'NR'
],[
'country_id' => 209,
'name' => 'East Darfur',
'iso2' => 'DE'
],[
'country_id' => 209,
'name' => 'North Kordofan',
'iso2' => 'KN'
],[
'country_id' => 209,
'name' => 'South Darfur',
'iso2' => 'DS'
],[
'country_id' => 209,
'name' => 'Northern',
'iso2' => 'NO'
],[
'country_id' => 209,
'name' => 'Central Darfur',
'iso2' => 'DC'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
