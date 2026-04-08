<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class SVStateSMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1187,
'name' => 'Chapeltique'
],[
'state_id' => 1187,
'name' => 'Chinameca'
],[
'state_id' => 1187,
'name' => 'Chirilagua'
],[
'state_id' => 1187,
'name' => 'Ciudad Barrios'
],[
'state_id' => 1187,
'name' => 'El Tránsito'
],[
'state_id' => 1187,
'name' => 'Lolotique'
],[
'state_id' => 1187,
'name' => 'Moncagua'
],[
'state_id' => 1187,
'name' => 'Nueva Guadalupe'
],[
'state_id' => 1187,
'name' => 'San Miguel'
],[
'state_id' => 1187,
'name' => 'San Rafael Oriente'
],[
'state_id' => 1187,
'name' => 'Sesori'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
