<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TDStateGRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 752,
'name' => 'Bitkine'
],[
'state_id' => 752,
'name' => 'Melfi'
],[
'state_id' => 752,
'name' => 'Mongo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
