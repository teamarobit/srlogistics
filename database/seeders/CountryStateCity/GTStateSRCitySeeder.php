<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStateSRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1509,
'name' => 'Barberena'
],[
'state_id' => 1509,
'name' => 'Casillas'
],[
'state_id' => 1509,
'name' => 'Chiquimulilla'
],[
'state_id' => 1509,
'name' => 'Cuilapa'
],[
'state_id' => 1509,
'name' => 'Guazacapán'
],[
'state_id' => 1509,
'name' => 'Municipio de Casillas'
],[
'state_id' => 1509,
'name' => 'Municipio de Chiquimulilla'
],[
'state_id' => 1509,
'name' => 'Municipio de Guazacapán'
],[
'state_id' => 1509,
'name' => 'Nueva Santa Rosa'
],[
'state_id' => 1509,
'name' => 'Oratorio'
],[
'state_id' => 1509,
'name' => 'Pueblo Nuevo Viñas'
],[
'state_id' => 1509,
'name' => 'San Juan Tecuaco'
],[
'state_id' => 1509,
'name' => 'San Rafael Las Flores'
],[
'state_id' => 1509,
'name' => 'Santa Cruz Naranjo'
],[
'state_id' => 1509,
'name' => 'Santa María Ixhuatán'
],[
'state_id' => 1509,
'name' => 'Santa Rosa de Lima'
],[
'state_id' => 1509,
'name' => 'Taxisco'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
