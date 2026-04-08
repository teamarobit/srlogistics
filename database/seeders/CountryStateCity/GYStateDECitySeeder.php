<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GYStateDECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1580,
'name' => 'Georgetown'
],[
'state_id' => 1580,
'name' => 'Mahaica Village'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
