<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HNStateCLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1603,
'name' => 'Balfate'
],[
'state_id' => 1603,
'name' => 'Bonito Oriental'
],[
'state_id' => 1603,
'name' => 'Corocito'
],[
'state_id' => 1603,
'name' => 'Cusuna'
],[
'state_id' => 1603,
'name' => 'Elíxir'
],[
'state_id' => 1603,
'name' => 'Francia'
],[
'state_id' => 1603,
'name' => 'Iriona'
],[
'state_id' => 1603,
'name' => 'Jericó'
],[
'state_id' => 1603,
'name' => 'La Brea'
],[
'state_id' => 1603,
'name' => 'La Esperanza'
],[
'state_id' => 1603,
'name' => 'Limón'
],[
'state_id' => 1603,
'name' => 'Municipio de Sabá'
],[
'state_id' => 1603,
'name' => 'Prieta'
],[
'state_id' => 1603,
'name' => 'Puerto Castilla'
],[
'state_id' => 1603,
'name' => 'Punta Piedra'
],[
'state_id' => 1603,
'name' => 'Quebrada de Arena'
],[
'state_id' => 1603,
'name' => 'Río Esteban'
],[
'state_id' => 1603,
'name' => 'Sabá'
],[
'state_id' => 1603,
'name' => 'Salamá'
],[
'state_id' => 1603,
'name' => 'Santa Fe'
],[
'state_id' => 1603,
'name' => 'Santa Rosa de Aguán'
],[
'state_id' => 1603,
'name' => 'Sonaguera'
],[
'state_id' => 1603,
'name' => 'Taujica'
],[
'state_id' => 1603,
'name' => 'Tocoa'
],[
'state_id' => 1603,
'name' => 'Trujillo'
],[
'state_id' => 1603,
'name' => 'Zamora'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
