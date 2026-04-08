<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HNStateCPCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1601,
'name' => 'Agua Caliente'
],[
'state_id' => 1601,
'name' => 'Buenos Aires'
],[
'state_id' => 1601,
'name' => 'Cabañas'
],[
'state_id' => 1601,
'name' => 'Chalmeca'
],[
'state_id' => 1601,
'name' => 'Concepción'
],[
'state_id' => 1601,
'name' => 'Concepción de la Barranca'
],[
'state_id' => 1601,
'name' => 'Copán'
],[
'state_id' => 1601,
'name' => 'Copán Ruinas'
],[
'state_id' => 1601,
'name' => 'Corquín'
],[
'state_id' => 1601,
'name' => 'Cucuyagua'
],[
'state_id' => 1601,
'name' => 'Dolores'
],[
'state_id' => 1601,
'name' => 'Dulce Nombre'
],[
'state_id' => 1601,
'name' => 'El Corpus'
],[
'state_id' => 1601,
'name' => 'El Ocotón'
],[
'state_id' => 1601,
'name' => 'El Paraíso'
],[
'state_id' => 1601,
'name' => 'Florida'
],[
'state_id' => 1601,
'name' => 'La Entrada'
],[
'state_id' => 1601,
'name' => 'La Jigua'
],[
'state_id' => 1601,
'name' => 'La Playona'
],[
'state_id' => 1601,
'name' => 'La Unión'
],[
'state_id' => 1601,
'name' => 'La Zumbadora'
],[
'state_id' => 1601,
'name' => 'Los Tangos'
],[
'state_id' => 1601,
'name' => 'Nueva Arcadia'
],[
'state_id' => 1601,
'name' => 'Ojos de Agua'
],[
'state_id' => 1601,
'name' => 'Pueblo Nuevo'
],[
'state_id' => 1601,
'name' => 'Quezailica'
],[
'state_id' => 1601,
'name' => 'San Agustín'
],[
'state_id' => 1601,
'name' => 'San Antonio'
],[
'state_id' => 1601,
'name' => 'San Jerónimo'
],[
'state_id' => 1601,
'name' => 'San Joaquín'
],[
'state_id' => 1601,
'name' => 'San José'
],[
'state_id' => 1601,
'name' => 'San José de Copán'
],[
'state_id' => 1601,
'name' => 'San Juan de Opoa'
],[
'state_id' => 1601,
'name' => 'San Juan de Planes'
],[
'state_id' => 1601,
'name' => 'San Nicolás'
],[
'state_id' => 1601,
'name' => 'San Pedro de Copán'
],[
'state_id' => 1601,
'name' => 'Santa Rita'
],[
'state_id' => 1601,
'name' => 'Santa Rita Copan'
],[
'state_id' => 1601,
'name' => 'Santa Rosa de Copán'
],[
'state_id' => 1601,
'name' => 'Trinidad de Copán'
],[
'state_id' => 1601,
'name' => 'Veracruz'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
