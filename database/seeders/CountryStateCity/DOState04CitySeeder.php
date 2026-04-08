<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState04CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1089,
'name' => 'Cabral'
],[
'state_id' => 1089,
'name' => 'Cachón'
],[
'state_id' => 1089,
'name' => 'Canoa'
],[
'state_id' => 1089,
'name' => 'El Peñón'
],[
'state_id' => 1089,
'name' => 'Enriquillo'
],[
'state_id' => 1089,
'name' => 'Fundación'
],[
'state_id' => 1089,
'name' => 'Jaquimeyes'
],[
'state_id' => 1089,
'name' => 'La Ciénaga'
],[
'state_id' => 1089,
'name' => 'Las Salinas'
],[
'state_id' => 1089,
'name' => 'Paraíso'
],[
'state_id' => 1089,
'name' => 'Pescadería'
],[
'state_id' => 1089,
'name' => 'Polo'
],[
'state_id' => 1089,
'name' => 'Santa Cruz de Barahona'
],[
'state_id' => 1089,
'name' => 'Vicente Noble'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
