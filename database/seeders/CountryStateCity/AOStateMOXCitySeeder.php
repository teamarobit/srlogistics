<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AOStateMOXCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 153,
'name' => 'Luau'
],[
'state_id' => 153,
'name' => 'Luena'
],[
'state_id' => 153,
'name' => 'Lumeje'
],[
'state_id' => 153,
'name' => 'Léua'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
