<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GMStateBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1404,
'name' => 'Bakau'
],[
'state_id' => 1404,
'name' => 'Banjul'
],[
'state_id' => 1404,
'name' => 'Kombo Saint Mary District'
],[
'state_id' => 1404,
'name' => 'Serekunda'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
