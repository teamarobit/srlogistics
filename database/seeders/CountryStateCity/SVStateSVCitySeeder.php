<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class SVStateSVCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1179,
'name' => 'Apastepeque'
],[
'state_id' => 1179,
'name' => 'San Sebastián'
],[
'state_id' => 1179,
'name' => 'San Vicente'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
