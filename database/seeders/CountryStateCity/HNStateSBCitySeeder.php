<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HNStateSBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1605,
'name' => 'Agualote'
],[
'state_id' => 1605,
'name' => 'Arada'
],[
'state_id' => 1605,
'name' => 'Atima'
],[
'state_id' => 1605,
'name' => 'Azacualpa'
],[
'state_id' => 1605,
'name' => 'Berlín'
],[
'state_id' => 1605,
'name' => 'Callejones'
],[
'state_id' => 1605,
'name' => 'Camalote'
],[
'state_id' => 1605,
'name' => 'Casa Quemada'
],[
'state_id' => 1605,
'name' => 'Ceguaca'
],[
'state_id' => 1605,
'name' => 'Chinda'
],[
'state_id' => 1605,
'name' => 'Concepción del Norte'
],[
'state_id' => 1605,
'name' => 'Concepción del Sur'
],[
'state_id' => 1605,
'name' => 'Correderos'
],[
'state_id' => 1605,
'name' => 'El Ciruelo'
],[
'state_id' => 1605,
'name' => 'El Corozal'
],[
'state_id' => 1605,
'name' => 'El Mochito'
],[
'state_id' => 1605,
'name' => 'El Níspero'
],[
'state_id' => 1605,
'name' => 'Guacamaya'
],[
'state_id' => 1605,
'name' => 'Gualala'
],[
'state_id' => 1605,
'name' => 'Gualjoco'
],[
'state_id' => 1605,
'name' => 'Ilama'
],[
'state_id' => 1605,
'name' => 'Joconal'
],[
'state_id' => 1605,
'name' => 'La Flecha'
],[
'state_id' => 1605,
'name' => 'Laguna Verde'
],[
'state_id' => 1605,
'name' => 'Las Vegas'
],[
'state_id' => 1605,
'name' => 'Las Vegas Santa Barbara'
],[
'state_id' => 1605,
'name' => 'Loma Alta'
],[
'state_id' => 1605,
'name' => 'Macuelizo'
],[
'state_id' => 1605,
'name' => 'Naco'
],[
'state_id' => 1605,
'name' => 'Naranjito'
],[
'state_id' => 1605,
'name' => 'Nueva Frontera'
],[
'state_id' => 1605,
'name' => 'Nueva Jalapa'
],[
'state_id' => 1605,
'name' => 'Nuevo Celilac'
],[
'state_id' => 1605,
'name' => 'Petoa'
],[
'state_id' => 1605,
'name' => 'Pinalejo'
],[
'state_id' => 1605,
'name' => 'Protección'
],[
'state_id' => 1605,
'name' => 'Quimistán'
],[
'state_id' => 1605,
'name' => 'San Francisco de Ojuera'
],[
'state_id' => 1605,
'name' => 'San José de Colinas'
],[
'state_id' => 1605,
'name' => 'San José de Tarros'
],[
'state_id' => 1605,
'name' => 'San Luis'
],[
'state_id' => 1605,
'name' => 'San Luis de Planes'
],[
'state_id' => 1605,
'name' => 'San Marcos'
],[
'state_id' => 1605,
'name' => 'San Nicolás'
],[
'state_id' => 1605,
'name' => 'San Pedro Zacapa'
],[
'state_id' => 1605,
'name' => 'San Vicente Centenario'
],[
'state_id' => 1605,
'name' => 'Santa Bárbara'
],[
'state_id' => 1605,
'name' => 'Santa Rita'
],[
'state_id' => 1605,
'name' => 'Sula'
],[
'state_id' => 1605,
'name' => 'Tras Cerros'
],[
'state_id' => 1605,
'name' => 'Trinidad'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
