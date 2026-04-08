<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GHStateSVCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1454,
'name' => 'Bole'
],[
'state_id' => 1454,
'name' => 'Central Gonja'
],[
'state_id' => 1454,
'name' => 'North Gonja'
],[
'state_id' => 1454,
'name' => 'East Gonja'
],[
'state_id' => 1454,
'name' => 'North East Gonja'
],[
'state_id' => 1454,
'name' => 'Sawla-Tuna-Kalba'
],[
'state_id' => 1454,
'name' => 'West Gonja'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
