<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateZCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 186,
'name' => '28 de Noviembre'
],[
'state_id' => 186,
'name' => 'Caleta Olivia'
],[
'state_id' => 186,
'name' => 'Comandante Luis Piedra Buena'
],[
'state_id' => 186,
'name' => 'Departamento de Deseado'
],[
'state_id' => 186,
'name' => 'Departamento de Güer Aike'
],[
'state_id' => 186,
'name' => 'Departamento de Lago Argentino'
],[
'state_id' => 186,
'name' => 'Departamento de Magallanes'
],[
'state_id' => 186,
'name' => 'Departamento de Río Chico'
],[
'state_id' => 186,
'name' => 'El Calafate'
],[
'state_id' => 186,
'name' => 'Gobernador Gregores'
],[
'state_id' => 186,
'name' => 'Las Heras'
],[
'state_id' => 186,
'name' => 'Los Antiguos'
],[
'state_id' => 186,
'name' => 'Perito Moreno'
],[
'state_id' => 186,
'name' => 'Pico Truncado'
],[
'state_id' => 186,
'name' => 'Puerto Deseado'
],[
'state_id' => 186,
'name' => 'Puerto Santa Cruz'
],[
'state_id' => 186,
'name' => 'Río Gallegos'
],[
'state_id' => 186,
'name' => 'Río Turbio'
],[
'state_id' => 186,
'name' => 'San Julián'
],[
'state_id' => 186,
'name' => 'Yacimiento Río Turbio'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
