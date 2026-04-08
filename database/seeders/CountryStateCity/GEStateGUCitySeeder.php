<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GEStateGUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1420,
'name' => 'Lanchkhuti'
],[
'state_id' => 1420,
'name' => 'Naruja'
],[
'state_id' => 1420,
'name' => 'Ozurgeti'
],[
'state_id' => 1420,
'name' => 'Urek’i'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
