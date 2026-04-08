<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateKCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 184,
'name' => 'Ancasti'
],[
'state_id' => 184,
'name' => 'Andalgalá'
],[
'state_id' => 184,
'name' => 'Antofagasta de la Sierra'
],[
'state_id' => 184,
'name' => 'Capayán'
],[
'state_id' => 184,
'name' => 'Departamento de Ambato'
],[
'state_id' => 184,
'name' => 'Departamento de Ancasti'
],[
'state_id' => 184,
'name' => 'Departamento de Andalgalá'
],[
'state_id' => 184,
'name' => 'Departamento de Antofagasta de la Sierra'
],[
'state_id' => 184,
'name' => 'Departamento de Capayán'
],[
'state_id' => 184,
'name' => 'Departamento de Capital'
],[
'state_id' => 184,
'name' => 'Departamento de El Alto'
],[
'state_id' => 184,
'name' => 'Departamento de Fray Mamerto Esquiú'
],[
'state_id' => 184,
'name' => 'Departamento de La Paz'
],[
'state_id' => 184,
'name' => 'Departamento de Pomán'
],[
'state_id' => 184,
'name' => 'Departamento de Santa María'
],[
'state_id' => 184,
'name' => 'Departamento de Santa Rosa'
],[
'state_id' => 184,
'name' => 'Departamento de Tinogasta'
],[
'state_id' => 184,
'name' => 'Departamento de Valle Viejo'
],[
'state_id' => 184,
'name' => 'El Rodeo'
],[
'state_id' => 184,
'name' => 'Fiambalá'
],[
'state_id' => 184,
'name' => 'Hualfín'
],[
'state_id' => 184,
'name' => 'Huillapima'
],[
'state_id' => 184,
'name' => 'Icaño'
],[
'state_id' => 184,
'name' => 'La Puerta de San José'
],[
'state_id' => 184,
'name' => 'Londres'
],[
'state_id' => 184,
'name' => 'Los Altos'
],[
'state_id' => 184,
'name' => 'Los Varela'
],[
'state_id' => 184,
'name' => 'Mutquín'
],[
'state_id' => 184,
'name' => 'Pomán'
],[
'state_id' => 184,
'name' => 'Puerta de Corral Quemado'
],[
'state_id' => 184,
'name' => 'Recreo'
],[
'state_id' => 184,
'name' => 'San Antonio'
],[
'state_id' => 184,
'name' => 'San Fernando del Valle de Catamarca'
],[
'state_id' => 184,
'name' => 'Santa María'
],[
'state_id' => 184,
'name' => 'Tinogasta'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
