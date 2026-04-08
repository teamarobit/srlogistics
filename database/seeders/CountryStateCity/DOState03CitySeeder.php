<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState03CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1104,
'name' => 'El Palmar'
],[
'state_id' => 1104,
'name' => 'Galván'
],[
'state_id' => 1104,
'name' => 'La Uvilla'
],[
'state_id' => 1104,
'name' => 'Los Ríos'
],[
'state_id' => 1104,
'name' => 'Neiba'
],[
'state_id' => 1104,
'name' => 'Tamayo'
],[
'state_id' => 1104,
'name' => 'Villa Jaragua'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
