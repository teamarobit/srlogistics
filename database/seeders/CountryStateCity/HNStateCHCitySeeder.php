<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HNStateCHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1593,
'name' => 'Apacilagua'
],[
'state_id' => 1593,
'name' => 'Choluteca'
],[
'state_id' => 1593,
'name' => 'Ciudad Choluteca'
],[
'state_id' => 1593,
'name' => 'Concepción de María'
],[
'state_id' => 1593,
'name' => 'Corpus'
],[
'state_id' => 1593,
'name' => 'Duyure'
],[
'state_id' => 1593,
'name' => 'El Corpus'
],[
'state_id' => 1593,
'name' => 'El Obraje'
],[
'state_id' => 1593,
'name' => 'El Puente'
],[
'state_id' => 1593,
'name' => 'El Triunfo'
],[
'state_id' => 1593,
'name' => 'Los Llanitos'
],[
'state_id' => 1593,
'name' => 'Marcovia'
],[
'state_id' => 1593,
'name' => 'Monjarás'
],[
'state_id' => 1593,
'name' => 'Morolica'
],[
'state_id' => 1593,
'name' => 'Namasigüe'
],[
'state_id' => 1593,
'name' => 'Orocuina'
],[
'state_id' => 1593,
'name' => 'Pespire'
],[
'state_id' => 1593,
'name' => 'San Antonio de Flores'
],[
'state_id' => 1593,
'name' => 'San Isidro'
],[
'state_id' => 1593,
'name' => 'San Jerónimo'
],[
'state_id' => 1593,
'name' => 'San José'
],[
'state_id' => 1593,
'name' => 'San José de Las Conchas'
],[
'state_id' => 1593,
'name' => 'San Marcos de Colón'
],[
'state_id' => 1593,
'name' => 'Santa Ana de Yusguare'
],[
'state_id' => 1593,
'name' => 'Santa Cruz'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
