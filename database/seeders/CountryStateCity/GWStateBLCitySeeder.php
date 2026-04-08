<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GWStateBLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1572,
'name' => 'Bolama'
],[
'state_id' => 1572,
'name' => 'Bubaque'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
