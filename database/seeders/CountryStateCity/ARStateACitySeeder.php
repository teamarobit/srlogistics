<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 180,
'name' => 'Apolinario Saravia'
],[
'state_id' => 180,
'name' => 'Cachí'
],[
'state_id' => 180,
'name' => 'Cafayate'
],[
'state_id' => 180,
'name' => 'Campo Quijano'
],[
'state_id' => 180,
'name' => 'Chicoana'
],[
'state_id' => 180,
'name' => 'Departamento Capital'
],[
'state_id' => 180,
'name' => 'Departamento de Anta'
],[
'state_id' => 180,
'name' => 'Departamento de Cerrillos'
],[
'state_id' => 180,
'name' => 'Departamento de Chicoana'
],[
'state_id' => 180,
'name' => 'Departamento de General Güemes'
],[
'state_id' => 180,
'name' => 'Departamento de Guachipas'
],[
'state_id' => 180,
'name' => 'Departamento de Iruya'
],[
'state_id' => 180,
'name' => 'Departamento de La Poma'
],[
'state_id' => 180,
'name' => 'Departamento de La Viña'
],[
'state_id' => 180,
'name' => 'Departamento de Los Andes'
],[
'state_id' => 180,
'name' => 'Departamento de Metán'
],[
'state_id' => 180,
'name' => 'Departamento de Rivadavia'
],[
'state_id' => 180,
'name' => 'Departamento de Rosario de Lerma'
],[
'state_id' => 180,
'name' => 'Departamento de Rosario de la Frontera'
],[
'state_id' => 180,
'name' => 'Departamento de San Carlos'
],[
'state_id' => 180,
'name' => 'El Carril'
],[
'state_id' => 180,
'name' => 'El Galpón'
],[
'state_id' => 180,
'name' => 'El Quebrachal'
],[
'state_id' => 180,
'name' => 'Embarcación'
],[
'state_id' => 180,
'name' => 'General Enrique Mosconi'
],[
'state_id' => 180,
'name' => 'Joaquín V. González'
],[
'state_id' => 180,
'name' => 'La Caldera'
],[
'state_id' => 180,
'name' => 'Las Lajitas'
],[
'state_id' => 180,
'name' => 'Salta'
],[
'state_id' => 180,
'name' => 'San Antonio de los Cobres'
],[
'state_id' => 180,
'name' => 'San Ramón de la Nueva Orán'
],[
'state_id' => 180,
'name' => 'Santa Rosa de Tastil'
],[
'state_id' => 180,
'name' => 'Tartagal'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
