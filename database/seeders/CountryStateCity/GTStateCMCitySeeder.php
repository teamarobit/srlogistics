<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStateCMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1519,
'name' => 'Acatenango'
],[
'state_id' => 1519,
'name' => 'Chimaltenango'
],[
'state_id' => 1519,
'name' => 'Comalapa'
],[
'state_id' => 1519,
'name' => 'El Tejar'
],[
'state_id' => 1519,
'name' => 'Parramos'
],[
'state_id' => 1519,
'name' => 'Patzicía'
],[
'state_id' => 1519,
'name' => 'Patzún'
],[
'state_id' => 1519,
'name' => 'Pochuta'
],[
'state_id' => 1519,
'name' => 'San Andrés Itzapa'
],[
'state_id' => 1519,
'name' => 'San José Poaquil'
],[
'state_id' => 1519,
'name' => 'San Martín Jilotepeque'
],[
'state_id' => 1519,
'name' => 'Santa Apolonia'
],[
'state_id' => 1519,
'name' => 'Santa Cruz Balanyá'
],[
'state_id' => 1519,
'name' => 'Tecpán Guatemala'
],[
'state_id' => 1519,
'name' => 'Yepocapa'
],[
'state_id' => 1519,
'name' => 'Zaragoza'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
