<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class FIStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 74,
'name' => 'Tavastia Proper',
'iso2' => '06'
],[
'country_id' => 74,
'name' => 'Central Ostrobothnia',
'iso2' => '07'
],[
'country_id' => 74,
'name' => 'Southern Savonia',
'iso2' => '04'
],[
'country_id' => 74,
'name' => 'Kainuu',
'iso2' => '05'
],[
'country_id' => 74,
'name' => 'South Karelia',
'iso2' => '02'
],[
'country_id' => 74,
'name' => 'Southern Ostrobothnia',
'iso2' => '03'
],[
'country_id' => 74,
'name' => 'Lapland',
'iso2' => '10'
],[
'country_id' => 74,
'name' => 'Satakunta',
'iso2' => '17'
],[
'country_id' => 74,
'name' => 'Päijänne Tavastia',
'iso2' => '16'
],[
'country_id' => 74,
'name' => 'Northern Savonia',
'iso2' => '15'
],[
'country_id' => 74,
'name' => 'North Karelia',
'iso2' => '13'
],[
'country_id' => 74,
'name' => 'Northern Ostrobothnia',
'iso2' => '14'
],[
'country_id' => 74,
'name' => 'Pirkanmaa',
'iso2' => '11'
],[
'country_id' => 74,
'name' => 'Finland Proper',
'iso2' => '19'
],[
'country_id' => 74,
'name' => 'Ostrobothnia',
'iso2' => '12'
],[
'country_id' => 74,
'name' => 'Åland Islands',
'iso2' => '01'
],[
'country_id' => 74,
'name' => 'Uusimaa',
'iso2' => '18'
],[
'country_id' => 74,
'name' => 'Central Finland',
'iso2' => '08'
],[
'country_id' => 74,
'name' => 'Kymenlaakso',
'iso2' => '09'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
