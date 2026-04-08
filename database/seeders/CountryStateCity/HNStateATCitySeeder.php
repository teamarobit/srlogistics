<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HNStateATCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1599,
'name' => 'Arizona'
],[
'state_id' => 1599,
'name' => 'Atenas de San Cristóbal'
],[
'state_id' => 1599,
'name' => 'Corozal'
],[
'state_id' => 1599,
'name' => 'El Pino'
],[
'state_id' => 1599,
'name' => 'El Porvenir'
],[
'state_id' => 1599,
'name' => 'El Triunfo de la Cruz'
],[
'state_id' => 1599,
'name' => 'Esparta'
],[
'state_id' => 1599,
'name' => 'Jutiapa'
],[
'state_id' => 1599,
'name' => 'La Ceiba'
],[
'state_id' => 1599,
'name' => 'La Masica'
],[
'state_id' => 1599,
'name' => 'La Unión'
],[
'state_id' => 1599,
'name' => 'Mezapa'
],[
'state_id' => 1599,
'name' => 'Nueva Armenia'
],[
'state_id' => 1599,
'name' => 'Sambo Creek'
],[
'state_id' => 1599,
'name' => 'San Antonio'
],[
'state_id' => 1599,
'name' => 'San Francisco'
],[
'state_id' => 1599,
'name' => 'San Juan Pueblo'
],[
'state_id' => 1599,
'name' => 'Santa Ana'
],[
'state_id' => 1599,
'name' => 'Tela'
],[
'state_id' => 1599,
'name' => 'Tornabé'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
