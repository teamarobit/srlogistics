<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BOStateTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 495,
'name' => 'Bermejo'
],[
'state_id' => 495,
'name' => 'Entre Ríos'
],[
'state_id' => 495,
'name' => 'Provincia Arce'
],[
'state_id' => 495,
'name' => 'Provincia Avilez'
],[
'state_id' => 495,
'name' => 'Provincia Cercado'
],[
'state_id' => 495,
'name' => 'Provincia Gran Chaco'
],[
'state_id' => 495,
'name' => 'Provincia Méndez'
],[
'state_id' => 495,
'name' => 'Provincia O’Connor'
],[
'state_id' => 495,
'name' => 'Tarija'
],[
'state_id' => 495,
'name' => 'Villamontes'
],[
'state_id' => 495,
'name' => 'Yacuiba'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
