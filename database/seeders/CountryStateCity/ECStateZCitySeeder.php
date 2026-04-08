<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ECStateZCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1132,
'name' => 'Yantzaza'
],[
'state_id' => 1132,
'name' => 'Zamora'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
