<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AOStateLSUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 154,
'name' => 'Cazaji'
],[
'state_id' => 154,
'name' => 'Saurimo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
