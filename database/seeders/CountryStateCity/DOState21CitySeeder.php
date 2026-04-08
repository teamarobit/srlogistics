<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState21CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1090,
'name' => 'Bajos de Haina'
],[
'state_id' => 1090,
'name' => 'Cambita Garabitos'
],[
'state_id' => 1090,
'name' => 'El Cacao'
],[
'state_id' => 1090,
'name' => 'El Carril'
],[
'state_id' => 1090,
'name' => 'Sabana Grande de Palenque'
],[
'state_id' => 1090,
'name' => 'San Cristóbal'
],[
'state_id' => 1090,
'name' => 'San Gregorio de Nigua'
],[
'state_id' => 1090,
'name' => 'Villa Altagracia'
],[
'state_id' => 1090,
'name' => 'Yaguate'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
