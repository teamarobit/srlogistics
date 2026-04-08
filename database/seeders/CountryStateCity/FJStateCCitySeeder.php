<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FJStateCCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1247,
'name' => 'Naitasiri Province'
],[
'state_id' => 1247,
'name' => 'Namosi Province'
],[
'state_id' => 1247,
'name' => 'Rewa Province'
],[
'state_id' => 1247,
'name' => 'Serua Province'
],[
'state_id' => 1247,
'name' => 'Suva'
],[
'state_id' => 1247,
'name' => 'Tailevu Province'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
