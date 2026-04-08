<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class OMStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 166,
'name' => 'Ad Dhahirah',
'iso2' => 'ZA'
],[
'country_id' => 166,
'name' => 'Al Batinah North',
'iso2' => 'BS'
],[
'country_id' => 166,
'name' => 'Al Batinah South',
'iso2' => 'BJ'
],[
'country_id' => 166,
'name' => 'Al Batinah Region',
'iso2' => 'BA'
],[
'country_id' => 166,
'name' => 'Ash Sharqiyah Region',
'iso2' => 'SH'
],[
'country_id' => 166,
'name' => 'Musandam',
'iso2' => 'MU'
],[
'country_id' => 166,
'name' => 'Ash Sharqiyah North',
'iso2' => 'SS'
],[
'country_id' => 166,
'name' => 'Ash Sharqiyah South',
'iso2' => 'SJ'
],[
'country_id' => 166,
'name' => 'Muscat',
'iso2' => 'MA'
],[
'country_id' => 166,
'name' => 'Al Wusta',
'iso2' => 'WU'
],[
'country_id' => 166,
'name' => 'Dhofar',
'iso2' => 'ZU'
],[
'country_id' => 166,
'name' => 'Ad Dakhiliyah',
'iso2' => 'DA'
],[
'country_id' => 166,
'name' => 'Al Buraimi',
'iso2' => 'BU'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
