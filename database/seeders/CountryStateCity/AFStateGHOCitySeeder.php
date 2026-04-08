<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStateGHOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 19,
'name' => 'Fayrōz Kōh'
],[
'state_id' => 19,
'name' => 'Shahrak'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
