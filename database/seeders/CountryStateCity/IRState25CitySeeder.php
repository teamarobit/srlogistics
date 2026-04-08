<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState25CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1755,
'name' => 'Qom'
],[
'state_id' => 1755,
'name' => 'Jafarie'
],[
'state_id' => 1755,
'name' => 'Dastjerd'
],[
'state_id' => 1755,
'name' => 'Salafchegan'
],[
'state_id' => 1755,
'name' => 'Qanavat'
],[
'state_id' => 1755,
'name' => 'Kahak'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
