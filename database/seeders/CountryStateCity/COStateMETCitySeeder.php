<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateMETCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 823,
'name' => 'Acacías'
],[
'state_id' => 823,
'name' => 'Barranca de Upía'
],[
'state_id' => 823,
'name' => 'Cabuyaro'
],[
'state_id' => 823,
'name' => 'Castilla la Nueva'
],[
'state_id' => 823,
'name' => 'Cubarral'
],[
'state_id' => 823,
'name' => 'Cumaral'
],[
'state_id' => 823,
'name' => 'El Calvario'
],[
'state_id' => 823,
'name' => 'El Castillo'
],[
'state_id' => 823,
'name' => 'Fuente de Oro'
],[
'state_id' => 823,
'name' => 'Granada'
],[
'state_id' => 823,
'name' => 'Guamal'
],[
'state_id' => 823,
'name' => 'La Macarena'
],[
'state_id' => 823,
'name' => 'Lejanías'
],[
'state_id' => 823,
'name' => 'Mapiripán'
],[
'state_id' => 823,
'name' => 'Mesetas'
],[
'state_id' => 823,
'name' => 'Puerto Concordia'
],[
'state_id' => 823,
'name' => 'Puerto Gaitán'
],[
'state_id' => 823,
'name' => 'Puerto Lleras'
],[
'state_id' => 823,
'name' => 'Puerto López'
],[
'state_id' => 823,
'name' => 'Puerto Rico'
],[
'state_id' => 823,
'name' => 'Restrepo'
],[
'state_id' => 823,
'name' => 'San Carlos de Guaroa'
],[
'state_id' => 823,
'name' => 'San Juan de Arama'
],[
'state_id' => 823,
'name' => 'San Martín'
],[
'state_id' => 823,
'name' => 'Villavicencio'
],[
'state_id' => 823,
'name' => 'Vistahermosa'
],[
'state_id' => 823,
'name' => 'El Dorado'
],[
'state_id' => 823,
'name' => 'San Juanito'
],[
'state_id' => 823,
'name' => 'Uribe'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
