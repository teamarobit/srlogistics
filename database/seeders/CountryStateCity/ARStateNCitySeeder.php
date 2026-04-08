<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 181,
'name' => 'Alba Posse'
],[
'state_id' => 181,
'name' => 'Almafuerte'
],[
'state_id' => 181,
'name' => 'Aristóbulo del Valle'
],[
'state_id' => 181,
'name' => 'Arroyo del Medio'
],[
'state_id' => 181,
'name' => 'Azara'
],[
'state_id' => 181,
'name' => 'Bernardo de Irigoyen'
],[
'state_id' => 181,
'name' => 'Bonpland'
],[
'state_id' => 181,
'name' => 'Campo Grande'
],[
'state_id' => 181,
'name' => 'Campo Ramón'
],[
'state_id' => 181,
'name' => 'Campo Viera'
],[
'state_id' => 181,
'name' => 'Candelaria'
],[
'state_id' => 181,
'name' => 'Capioví'
],[
'state_id' => 181,
'name' => 'Caraguatay'
],[
'state_id' => 181,
'name' => 'Cerro Azul'
],[
'state_id' => 181,
'name' => 'Cerro Corá'
],[
'state_id' => 181,
'name' => 'Colonia Aurora'
],[
'state_id' => 181,
'name' => 'Concepción de la Sierra'
],[
'state_id' => 181,
'name' => 'Departamento de Apóstoles'
],[
'state_id' => 181,
'name' => 'Departamento de Cainguás'
],[
'state_id' => 181,
'name' => 'Departamento de Candelaria'
],[
'state_id' => 181,
'name' => 'Departamento de Capital'
],[
'state_id' => 181,
'name' => 'Departamento de Concepción de la Sierra'
],[
'state_id' => 181,
'name' => 'Departamento de Eldorado'
],[
'state_id' => 181,
'name' => 'Departamento de General Manuel Belgrano'
],[
'state_id' => 181,
'name' => 'Departamento de Guaraní'
],[
'state_id' => 181,
'name' => 'Departamento de Iguazú'
],[
'state_id' => 181,
'name' => 'Departamento de Leandro N. Alem'
],[
'state_id' => 181,
'name' => 'Departamento de Libertador General San Martín'
],[
'state_id' => 181,
'name' => 'Departamento de Montecarlo'
],[
'state_id' => 181,
'name' => 'Departamento de Oberá'
],[
'state_id' => 181,
'name' => 'Departamento de San Ignacio'
],[
'state_id' => 181,
'name' => 'Departamento de San Javier'
],[
'state_id' => 181,
'name' => 'Departamento de San Pedro'
],[
'state_id' => 181,
'name' => 'Departamento de Veinticinco de Mayo'
],[
'state_id' => 181,
'name' => 'Dos Arroyos'
],[
'state_id' => 181,
'name' => 'Dos de Mayo'
],[
'state_id' => 181,
'name' => 'El Alcázar'
],[
'state_id' => 181,
'name' => 'El Soberbio'
],[
'state_id' => 181,
'name' => 'Florentino Ameghino'
],[
'state_id' => 181,
'name' => 'Garuhapé'
],[
'state_id' => 181,
'name' => 'Garupá'
],[
'state_id' => 181,
'name' => 'General Alvear'
],[
'state_id' => 181,
'name' => 'Gobernador Roca'
],[
'state_id' => 181,
'name' => 'Guaraní'
],[
'state_id' => 181,
'name' => 'Jardín América'
],[
'state_id' => 181,
'name' => 'Loreto'
],[
'state_id' => 181,
'name' => 'Los Helechos'
],[
'state_id' => 181,
'name' => 'Mojón Grande'
],[
'state_id' => 181,
'name' => 'Montecarlo'
],[
'state_id' => 181,
'name' => 'Mártires'
],[
'state_id' => 181,
'name' => 'Oberá'
],[
'state_id' => 181,
'name' => 'Panambí'
],[
'state_id' => 181,
'name' => 'Picada Gobernador López'
],[
'state_id' => 181,
'name' => 'Posadas'
],[
'state_id' => 181,
'name' => 'Puerto Eldorado'
],[
'state_id' => 181,
'name' => 'Puerto Esperanza'
],[
'state_id' => 181,
'name' => 'Puerto Iguazú'
],[
'state_id' => 181,
'name' => 'Puerto Leoni'
],[
'state_id' => 181,
'name' => 'Puerto Libertad'
],[
'state_id' => 181,
'name' => 'Puerto Piray'
],[
'state_id' => 181,
'name' => 'Puerto Rico'
],[
'state_id' => 181,
'name' => 'Ruiz de Montoya'
],[
'state_id' => 181,
'name' => 'San José'
],[
'state_id' => 181,
'name' => 'San Pedro'
],[
'state_id' => 181,
'name' => 'San Vicente'
],[
'state_id' => 181,
'name' => 'Santa María'
],[
'state_id' => 181,
'name' => 'Santo Pipó'
],[
'state_id' => 181,
'name' => 'Tres Capones'
],[
'state_id' => 181,
'name' => 'Veinticinco de Mayo'
],[
'state_id' => 181,
'name' => 'Wanda'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
