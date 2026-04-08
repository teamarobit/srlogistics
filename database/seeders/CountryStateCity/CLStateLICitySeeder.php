<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CLStateLICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 784,
'name' => 'Chimbarongo'
],[
'state_id' => 784,
'name' => 'Graneros'
],[
'state_id' => 784,
'name' => 'Machalí'
],[
'state_id' => 784,
'name' => 'Rancagua'
],[
'state_id' => 784,
'name' => 'Rengo'
],[
'state_id' => 784,
'name' => 'San Vicente'
],[
'state_id' => 784,
'name' => 'Santa Cruz'
],[
'state_id' => 784,
'name' => 'Chépica'
],[
'state_id' => 784,
'name' => 'Codegua'
],[
'state_id' => 784,
'name' => 'Coltauco'
],[
'state_id' => 784,
'name' => 'Coínco'
],[
'state_id' => 784,
'name' => 'Doñihue'
],[
'state_id' => 784,
'name' => 'La Estrella'
],[
'state_id' => 784,
'name' => 'Las Cabras'
],[
'state_id' => 784,
'name' => 'Litueche'
],[
'state_id' => 784,
'name' => 'Lolol'
],[
'state_id' => 784,
'name' => 'Malloa'
],[
'state_id' => 784,
'name' => 'Marchigüe'
],[
'state_id' => 784,
'name' => 'Mostazal'
],[
'state_id' => 784,
'name' => 'Nancagua'
],[
'state_id' => 784,
'name' => 'Navidad'
],[
'state_id' => 784,
'name' => 'Olivar'
],[
'state_id' => 784,
'name' => 'Palmilla'
],[
'state_id' => 784,
'name' => 'Paredones'
],[
'state_id' => 784,
'name' => 'Peralillo'
],[
'state_id' => 784,
'name' => 'Peumo'
],[
'state_id' => 784,
'name' => 'Pichidegua'
],[
'state_id' => 784,
'name' => 'Pichilemu'
],[
'state_id' => 784,
'name' => 'Placilla'
],[
'state_id' => 784,
'name' => 'Pumanque'
],[
'state_id' => 784,
'name' => 'Quinta de Tilcoco'
],[
'state_id' => 784,
'name' => 'Requínoa'
],[
'state_id' => 784,
'name' => 'San Fernando'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
