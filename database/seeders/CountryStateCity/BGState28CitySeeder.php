<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState28CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 578,
'name' => 'Bolyarovo'
],[
'state_id' => 578,
'name' => 'Elhovo'
],[
'state_id' => 578,
'name' => 'Obshtina Bolyarovo'
],[
'state_id' => 578,
'name' => 'Obshtina Elhovo'
],[
'state_id' => 578,
'name' => 'Obshtina Straldzha'
],[
'state_id' => 578,
'name' => 'Obshtina Tundzha'
],[
'state_id' => 578,
'name' => 'Obshtina Yambol'
],[
'state_id' => 578,
'name' => 'Straldzha'
],[
'state_id' => 578,
'name' => 'Yambol'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
