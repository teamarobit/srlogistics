<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateWADCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1176,
'name' => 'Al Khārijah'
],[
'state_id' => 1176,
'name' => 'Qaşr al Farāfirah'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
