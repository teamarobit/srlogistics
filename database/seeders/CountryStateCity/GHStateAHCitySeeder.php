<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GHStateAHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1440,
'name' => 'Agogo'
],[
'state_id' => 1440,
'name' => 'Bekwai'
],[
'state_id' => 1440,
'name' => 'Ejura'
],[
'state_id' => 1440,
'name' => 'Konongo'
],[
'state_id' => 1440,
'name' => 'Kumasi'
],[
'state_id' => 1440,
'name' => 'Mampong'
],[
'state_id' => 1440,
'name' => 'Obuase'
],[
'state_id' => 1440,
'name' => 'Tafo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
