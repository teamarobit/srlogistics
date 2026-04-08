<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BOStateCCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 498,
'name' => 'Aiquile'
],[
'state_id' => 498,
'name' => 'Arani'
],[
'state_id' => 498,
'name' => 'Bolivar'
],[
'state_id' => 498,
'name' => 'Capinota'
],[
'state_id' => 498,
'name' => 'Chimoré'
],[
'state_id' => 498,
'name' => 'Cliza'
],[
'state_id' => 498,
'name' => 'Cochabamba'
],[
'state_id' => 498,
'name' => 'Colchani'
],[
'state_id' => 498,
'name' => 'Colomi'
],[
'state_id' => 498,
'name' => 'Independencia'
],[
'state_id' => 498,
'name' => 'Irpa Irpa'
],[
'state_id' => 498,
'name' => 'Mizque'
],[
'state_id' => 498,
'name' => 'Provincia Arani'
],[
'state_id' => 498,
'name' => 'Provincia Arque'
],[
'state_id' => 498,
'name' => 'Provincia Ayopaya'
],[
'state_id' => 498,
'name' => 'Provincia Campero'
],[
'state_id' => 498,
'name' => 'Provincia Capinota'
],[
'state_id' => 498,
'name' => 'Provincia Carrasco'
],[
'state_id' => 498,
'name' => 'Provincia Cercado'
],[
'state_id' => 498,
'name' => 'Provincia Chaparé'
],[
'state_id' => 498,
'name' => 'Provincia Esteban Arce'
],[
'state_id' => 498,
'name' => 'Provincia Germán Jordán'
],[
'state_id' => 498,
'name' => 'Provincia Mizque'
],[
'state_id' => 498,
'name' => 'Provincia Punata'
],[
'state_id' => 498,
'name' => 'Provincia Quillacollo'
],[
'state_id' => 498,
'name' => 'Provincia Tapacarí'
],[
'state_id' => 498,
'name' => 'Punata'
],[
'state_id' => 498,
'name' => 'Quillacollo'
],[
'state_id' => 498,
'name' => 'Sacaba'
],[
'state_id' => 498,
'name' => 'Sipe Sipe'
],[
'state_id' => 498,
'name' => 'Tarata'
],[
'state_id' => 498,
'name' => 'Tiquipaya'
],[
'state_id' => 498,
'name' => 'Tiraque Province'
],[
'state_id' => 498,
'name' => 'Totora'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
