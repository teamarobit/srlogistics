<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStatePCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 189,
'name' => 'Clorinda'
],[
'state_id' => 189,
'name' => 'Comandante Fontana'
],[
'state_id' => 189,
'name' => 'Departamento de Pilcomayo'
],[
'state_id' => 189,
'name' => 'El Colorado'
],[
'state_id' => 189,
'name' => 'Estanislao del Campo'
],[
'state_id' => 189,
'name' => 'Formosa'
],[
'state_id' => 189,
'name' => 'General Enrique Mosconi'
],[
'state_id' => 189,
'name' => 'Herradura'
],[
'state_id' => 189,
'name' => 'Ibarreta'
],[
'state_id' => 189,
'name' => 'Ingeniero Guillermo N. Juárez'
],[
'state_id' => 189,
'name' => 'Laguna Naick-Neck'
],[
'state_id' => 189,
'name' => 'Laguna Yema'
],[
'state_id' => 189,
'name' => 'Las Lomitas'
],[
'state_id' => 189,
'name' => 'Palo Santo'
],[
'state_id' => 189,
'name' => 'Pirané'
],[
'state_id' => 189,
'name' => 'Pozo del Tigre'
],[
'state_id' => 189,
'name' => 'Riacho Eh-Eh'
],[
'state_id' => 189,
'name' => 'San Francisco de Laishí'
],[
'state_id' => 189,
'name' => 'Villa Escolar'
],[
'state_id' => 189,
'name' => 'Villa General Guemes'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
