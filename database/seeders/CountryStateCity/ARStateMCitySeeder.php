<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 183,
'name' => 'Departamento de Capital'
],[
'state_id' => 183,
'name' => 'Departamento de General Alvear'
],[
'state_id' => 183,
'name' => 'Departamento de Godoy Cruz'
],[
'state_id' => 183,
'name' => 'Departamento de Guaymallén'
],[
'state_id' => 183,
'name' => 'Departamento de La Paz'
],[
'state_id' => 183,
'name' => 'Departamento de Las Heras'
],[
'state_id' => 183,
'name' => 'Departamento de Lavalle'
],[
'state_id' => 183,
'name' => 'Departamento de Luján'
],[
'state_id' => 183,
'name' => 'Departamento de Maipú'
],[
'state_id' => 183,
'name' => 'Departamento de Malargüe'
],[
'state_id' => 183,
'name' => 'Departamento de Rivadavia'
],[
'state_id' => 183,
'name' => 'Departamento de San Carlos'
],[
'state_id' => 183,
'name' => 'Departamento de San Martín'
],[
'state_id' => 183,
'name' => 'Departamento de San Rafael'
],[
'state_id' => 183,
'name' => 'Departamento de Santa Rosa'
],[
'state_id' => 183,
'name' => 'Departamento de Tunuyán'
],[
'state_id' => 183,
'name' => 'Departamento de Tupungato'
],[
'state_id' => 183,
'name' => 'Godoy Cruz'
],[
'state_id' => 183,
'name' => 'Las Heras'
],[
'state_id' => 183,
'name' => 'Mendoza'
],[
'state_id' => 183,
'name' => 'San Martín'
],[
'state_id' => 183,
'name' => 'San Rafael'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
