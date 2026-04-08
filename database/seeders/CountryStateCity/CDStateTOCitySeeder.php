<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CDStateTOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 888,
'name' => 'Basoko'
],[
'state_id' => 888,
'name' => 'Kisangani'
],[
'state_id' => 888,
'name' => 'Yangambi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
