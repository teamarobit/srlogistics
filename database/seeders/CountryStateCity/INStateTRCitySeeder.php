<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateTRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1710,
'name' => 'Agartala'
],[
'state_id' => 1710,
'name' => 'Amarpur'
],[
'state_id' => 1710,
'name' => 'Barjala'
],[
'state_id' => 1710,
'name' => 'Belonia'
],[
'state_id' => 1710,
'name' => 'Dhalai'
],[
'state_id' => 1710,
'name' => 'Dharmanagar'
],[
'state_id' => 1710,
'name' => 'Gomati'
],[
'state_id' => 1710,
'name' => 'Kailashahar'
],[
'state_id' => 1710,
'name' => 'Kamalpur'
],[
'state_id' => 1710,
'name' => 'Khowai'
],[
'state_id' => 1710,
'name' => 'North Tripura'
],[
'state_id' => 1710,
'name' => 'Ranir Bazar'
],[
'state_id' => 1710,
'name' => 'Sabrum'
],[
'state_id' => 1710,
'name' => 'Sonamura'
],[
'state_id' => 1710,
'name' => 'South Tripura'
],[
'state_id' => 1710,
'name' => 'Udaipur'
],[
'state_id' => 1710,
'name' => 'Unakoti'
],[
'state_id' => 1710,
'name' => 'West Tripura'
],[
'state_id' => 1710,
'name' => 'Ambasa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
