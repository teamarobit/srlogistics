<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CUState05CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 960,
'name' => 'Caibarién'
],[
'state_id' => 960,
'name' => 'Calabazar de Sagua'
],[
'state_id' => 960,
'name' => 'Camajuaní'
],[
'state_id' => 960,
'name' => 'Cifuentes'
],[
'state_id' => 960,
'name' => 'Corralillo'
],[
'state_id' => 960,
'name' => 'Encrucijada'
],[
'state_id' => 960,
'name' => 'Esperanza'
],[
'state_id' => 960,
'name' => 'Isabela de Sagua'
],[
'state_id' => 960,
'name' => 'Manicaragua'
],[
'state_id' => 960,
'name' => 'Municipio de Placetas'
],[
'state_id' => 960,
'name' => 'Municipio de Santa Clara'
],[
'state_id' => 960,
'name' => 'Placetas'
],[
'state_id' => 960,
'name' => 'Quemado de Güines'
],[
'state_id' => 960,
'name' => 'Rancho Veloz'
],[
'state_id' => 960,
'name' => 'Ranchuelo'
],[
'state_id' => 960,
'name' => 'Sagua la Grande'
],[
'state_id' => 960,
'name' => 'Santa Clara'
],[
'state_id' => 960,
'name' => 'Santo Domingo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
