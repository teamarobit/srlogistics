<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HNStateOCCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1608,
'name' => 'Antigua Ocotepeque'
],[
'state_id' => 1608,
'name' => 'Belén Gualcho'
],[
'state_id' => 1608,
'name' => 'Concepción'
],[
'state_id' => 1608,
'name' => 'Dolores Merendón'
],[
'state_id' => 1608,
'name' => 'El Tránsito'
],[
'state_id' => 1608,
'name' => 'Fraternidad'
],[
'state_id' => 1608,
'name' => 'La Encarnación'
],[
'state_id' => 1608,
'name' => 'La Labor'
],[
'state_id' => 1608,
'name' => 'Lucerna'
],[
'state_id' => 1608,
'name' => 'Mercedes'
],[
'state_id' => 1608,
'name' => 'Nueva Ocotepeque'
],[
'state_id' => 1608,
'name' => 'San Fernando'
],[
'state_id' => 1608,
'name' => 'San Francisco de Cones'
],[
'state_id' => 1608,
'name' => 'San Francisco del Valle'
],[
'state_id' => 1608,
'name' => 'San Jorge'
],[
'state_id' => 1608,
'name' => 'San Marcos'
],[
'state_id' => 1608,
'name' => 'Santa Fe'
],[
'state_id' => 1608,
'name' => 'Santa Lucía'
],[
'state_id' => 1608,
'name' => 'Sensenti'
],[
'state_id' => 1608,
'name' => 'Sinuapa'
],[
'state_id' => 1608,
'name' => 'Yaruchel'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
