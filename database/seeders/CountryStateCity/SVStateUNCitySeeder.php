<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class SVStateUNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1190,
'name' => 'Anamorós'
],[
'state_id' => 1190,
'name' => 'Conchagua'
],[
'state_id' => 1190,
'name' => 'Intipucá'
],[
'state_id' => 1190,
'name' => 'La Unión'
],[
'state_id' => 1190,
'name' => 'Nueva Esparta'
],[
'state_id' => 1190,
'name' => 'Pasaquina'
],[
'state_id' => 1190,
'name' => 'San Alejo'
],[
'state_id' => 1190,
'name' => 'Santa Rosa de Lima'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
