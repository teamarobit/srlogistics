<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BZStateSCCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 447,
'name' => 'Dangriga'
],[
'state_id' => 447,
'name' => 'Placencia'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
