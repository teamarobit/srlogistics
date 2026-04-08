<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CUState15CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 963,
'name' => 'Alquízar'
],[
'state_id' => 963,
'name' => 'Artemisa'
],[
'state_id' => 963,
'name' => 'Bahía Honda'
],[
'state_id' => 963,
'name' => 'Bauta'
],[
'state_id' => 963,
'name' => 'Cabañas'
],[
'state_id' => 963,
'name' => 'Candelaria'
],[
'state_id' => 963,
'name' => 'Guanajay'
],[
'state_id' => 963,
'name' => 'Güira de Melena'
],[
'state_id' => 963,
'name' => 'Mariel'
],[
'state_id' => 963,
'name' => 'Municipio de Artemisa'
],[
'state_id' => 963,
'name' => 'Municipio de Bauta'
],[
'state_id' => 963,
'name' => 'Municipio de Guanajay'
],[
'state_id' => 963,
'name' => 'Municipio de Mariel'
],[
'state_id' => 963,
'name' => 'Municipio de San Cristóbal'
],[
'state_id' => 963,
'name' => 'San Antonio de los Baños'
],[
'state_id' => 963,
'name' => 'San Cristobal'
],[
'state_id' => 963,
'name' => 'Soroa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
