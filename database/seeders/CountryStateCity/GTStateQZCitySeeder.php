<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStateQZCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1512,
'name' => 'Almolonga'
],[
'state_id' => 1512,
'name' => 'Cabricán'
],[
'state_id' => 1512,
'name' => 'Cajolá'
],[
'state_id' => 1512,
'name' => 'Cantel'
],[
'state_id' => 1512,
'name' => 'Coatepeque'
],[
'state_id' => 1512,
'name' => 'Colomba'
],[
'state_id' => 1512,
'name' => 'Concepción Chiquirichapa'
],[
'state_id' => 1512,
'name' => 'El Palmar'
],[
'state_id' => 1512,
'name' => 'Flores Costa Cuca'
],[
'state_id' => 1512,
'name' => 'Génova'
],[
'state_id' => 1512,
'name' => 'Huitán'
],[
'state_id' => 1512,
'name' => 'La Esperanza'
],[
'state_id' => 1512,
'name' => 'Municipio de Almolonga'
],[
'state_id' => 1512,
'name' => 'Municipio de Cabricán'
],[
'state_id' => 1512,
'name' => 'Municipio de Cantel'
],[
'state_id' => 1512,
'name' => 'Municipio de Coatepeque'
],[
'state_id' => 1512,
'name' => 'Municipio de Colomba'
],[
'state_id' => 1512,
'name' => 'Municipio de Concepción Chiquirichapa'
],[
'state_id' => 1512,
'name' => 'Municipio de Flores Costa Cuca'
],[
'state_id' => 1512,
'name' => 'Municipio de San Juan Ostuncalco'
],[
'state_id' => 1512,
'name' => 'Olintepeque'
],[
'state_id' => 1512,
'name' => 'Ostuncalco'
],[
'state_id' => 1512,
'name' => 'Palestina de los Altos'
],[
'state_id' => 1512,
'name' => 'Quetzaltenango'
],[
'state_id' => 1512,
'name' => 'Salcajá'
],[
'state_id' => 1512,
'name' => 'Samayac'
],[
'state_id' => 1512,
'name' => 'San Carlos Sija'
],[
'state_id' => 1512,
'name' => 'San Francisco la Unión'
],[
'state_id' => 1512,
'name' => 'San Martín Sacatepéquez'
],[
'state_id' => 1512,
'name' => 'San Mateo'
],[
'state_id' => 1512,
'name' => 'San Miguel Sigüilá'
],[
'state_id' => 1512,
'name' => 'Sibilia'
],[
'state_id' => 1512,
'name' => 'Zunil'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
