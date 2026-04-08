<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ATState9CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 217,
'name' => 'Donaustadt'
],[
'state_id' => 217,
'name' => 'Favoriten'
],[
'state_id' => 217,
'name' => 'Floridsdorf'
],[
'state_id' => 217,
'name' => 'Hernals'
],[
'state_id' => 217,
'name' => 'Hietzing'
],[
'state_id' => 217,
'name' => 'Innere Stadt'
],[
'state_id' => 217,
'name' => 'Meidling'
],[
'state_id' => 217,
'name' => 'Ottakring'
],[
'state_id' => 217,
'name' => 'Simmering'
],[
'state_id' => 217,
'name' => 'Vienna'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
