<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 178,
'name' => 'Armstrong'
],[
'state_id' => 178,
'name' => 'Arroyo Seco'
],[
'state_id' => 178,
'name' => 'Arrufó'
],[
'state_id' => 178,
'name' => 'Avellaneda'
],[
'state_id' => 178,
'name' => 'Bella Italia'
],[
'state_id' => 178,
'name' => 'Calchaquí'
],[
'state_id' => 178,
'name' => 'Capitán Bermúdez'
],[
'state_id' => 178,
'name' => 'Carcarañá'
],[
'state_id' => 178,
'name' => 'Casilda'
],[
'state_id' => 178,
'name' => 'Cañada de Gómez'
],[
'state_id' => 178,
'name' => 'Ceres'
],[
'state_id' => 178,
'name' => 'Chañar Ladeado'
],[
'state_id' => 178,
'name' => 'Coronda'
],[
'state_id' => 178,
'name' => 'Departamento de Belgrano'
],[
'state_id' => 178,
'name' => 'Departamento de Caseros'
],[
'state_id' => 178,
'name' => 'Departamento de Castellanos'
],[
'state_id' => 178,
'name' => 'Departamento de Constitución'
],[
'state_id' => 178,
'name' => 'Departamento de La Capital'
],[
'state_id' => 178,
'name' => 'Departamento de Nueve de Julio'
],[
'state_id' => 178,
'name' => 'Departamento de San Cristóbal'
],[
'state_id' => 178,
'name' => 'Departamento de San Javier'
],[
'state_id' => 178,
'name' => 'Departamento de San Justo'
],[
'state_id' => 178,
'name' => 'Departamento de San Lorenzo'
],[
'state_id' => 178,
'name' => 'Departamento de San Martín'
],[
'state_id' => 178,
'name' => 'Departamento de Vera'
],[
'state_id' => 178,
'name' => 'El Trébol'
],[
'state_id' => 178,
'name' => 'Esperanza'
],[
'state_id' => 178,
'name' => 'Firmat'
],[
'state_id' => 178,
'name' => 'Fray Luis A. Beltrán'
],[
'state_id' => 178,
'name' => 'Funes'
],[
'state_id' => 178,
'name' => 'Gato Colorado'
],[
'state_id' => 178,
'name' => 'Gobernador Gálvez'
],[
'state_id' => 178,
'name' => 'Granadero Baigorria'
],[
'state_id' => 178,
'name' => 'Gálvez'
],[
'state_id' => 178,
'name' => 'Helvecia'
],[
'state_id' => 178,
'name' => 'Hersilia'
],[
'state_id' => 178,
'name' => 'Iriondo Department'
],[
'state_id' => 178,
'name' => 'Laguna Paiva'
],[
'state_id' => 178,
'name' => 'Las Parejas'
],[
'state_id' => 178,
'name' => 'Las Rosas'
],[
'state_id' => 178,
'name' => 'Las Toscas'
],[
'state_id' => 178,
'name' => 'Los Laureles'
],[
'state_id' => 178,
'name' => 'Malabrigo'
],[
'state_id' => 178,
'name' => 'Melincué'
],[
'state_id' => 178,
'name' => 'Pérez'
],[
'state_id' => 178,
'name' => 'Rafaela'
],[
'state_id' => 178,
'name' => 'Reconquista'
],[
'state_id' => 178,
'name' => 'Recreo'
],[
'state_id' => 178,
'name' => 'Roldán'
],[
'state_id' => 178,
'name' => 'Rosario'
],[
'state_id' => 178,
'name' => 'Rufino'
],[
'state_id' => 178,
'name' => 'San Carlos Centro'
],[
'state_id' => 178,
'name' => 'San Cristóbal'
],[
'state_id' => 178,
'name' => 'San Javier'
],[
'state_id' => 178,
'name' => 'San Jorge'
],[
'state_id' => 178,
'name' => 'San Justo'
],[
'state_id' => 178,
'name' => 'Santa Fe'
],[
'state_id' => 178,
'name' => 'Santo Tomé'
],[
'state_id' => 178,
'name' => 'Sastre'
],[
'state_id' => 178,
'name' => 'Sunchales'
],[
'state_id' => 178,
'name' => 'Tacuarendí'
],[
'state_id' => 178,
'name' => 'Tostado'
],[
'state_id' => 178,
'name' => 'Totoras'
],[
'state_id' => 178,
'name' => 'Venado Tuerto'
],[
'state_id' => 178,
'name' => 'Vera'
],[
'state_id' => 178,
'name' => 'Villa Cañás'
],[
'state_id' => 178,
'name' => 'Villa Constitución'
],[
'state_id' => 178,
'name' => 'Villa Mugueta'
],[
'state_id' => 178,
'name' => 'Villa Ocampo'
],[
'state_id' => 178,
'name' => 'Villa Trinidad'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
