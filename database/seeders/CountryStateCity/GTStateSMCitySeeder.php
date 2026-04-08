<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStateSMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1511,
'name' => 'Catarina'
],[
'state_id' => 1511,
'name' => 'Ciudad Tecún Umán'
],[
'state_id' => 1511,
'name' => 'Comitancillo'
],[
'state_id' => 1511,
'name' => 'Concepción Tutuapa'
],[
'state_id' => 1511,
'name' => 'El Quetzal'
],[
'state_id' => 1511,
'name' => 'El Rodeo'
],[
'state_id' => 1511,
'name' => 'El Tumbador'
],[
'state_id' => 1511,
'name' => 'Esquipulas Palo Gordo'
],[
'state_id' => 1511,
'name' => 'Ixchiguán'
],[
'state_id' => 1511,
'name' => 'La Reforma'
],[
'state_id' => 1511,
'name' => 'Malacatán'
],[
'state_id' => 1511,
'name' => 'Municipio de Concepción Tutuapa'
],[
'state_id' => 1511,
'name' => 'Municipio de Malacatán'
],[
'state_id' => 1511,
'name' => 'Municipio de Sipacapa'
],[
'state_id' => 1511,
'name' => 'Municipio de Tejutla'
],[
'state_id' => 1511,
'name' => 'Nuevo Progreso'
],[
'state_id' => 1511,
'name' => 'Ocós'
],[
'state_id' => 1511,
'name' => 'Pajapita'
],[
'state_id' => 1511,
'name' => 'Río Blanco'
],[
'state_id' => 1511,
'name' => 'San Antonio Sacatepéquez'
],[
'state_id' => 1511,
'name' => 'San Cristóbal Cucho'
],[
'state_id' => 1511,
'name' => 'San José Ojetenam'
],[
'state_id' => 1511,
'name' => 'San José Ojetenán'
],[
'state_id' => 1511,
'name' => 'San Lorenzo'
],[
'state_id' => 1511,
'name' => 'San Marcos'
],[
'state_id' => 1511,
'name' => 'San Miguel Ixtahuacán'
],[
'state_id' => 1511,
'name' => 'San Pablo'
],[
'state_id' => 1511,
'name' => 'San Pedro Sacatepéquez'
],[
'state_id' => 1511,
'name' => 'San Rafael Pie de la Cuesta'
],[
'state_id' => 1511,
'name' => 'Sibinal'
],[
'state_id' => 1511,
'name' => 'Sipacapa'
],[
'state_id' => 1511,
'name' => 'Tacaná'
],[
'state_id' => 1511,
'name' => 'Tajumulco'
],[
'state_id' => 1511,
'name' => 'Tejutla'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
