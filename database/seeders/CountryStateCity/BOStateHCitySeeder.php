<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BOStateHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 499,
'name' => 'Camargo'
],[
'state_id' => 499,
'name' => 'Monteagudo'
],[
'state_id' => 499,
'name' => 'Padilla'
],[
'state_id' => 499,
'name' => 'Provincia Azurduy'
],[
'state_id' => 499,
'name' => 'Provincia Belisario Boeto'
],[
'state_id' => 499,
'name' => 'Provincia Hernando Siles'
],[
'state_id' => 499,
'name' => 'Provincia Luis Calvo'
],[
'state_id' => 499,
'name' => 'Provincia Nor Cinti'
],[
'state_id' => 499,
'name' => 'Provincia Oropeza'
],[
'state_id' => 499,
'name' => 'Provincia Sud Cinti'
],[
'state_id' => 499,
'name' => 'Provincia Tomina'
],[
'state_id' => 499,
'name' => 'Provincia Yamparáez'
],[
'state_id' => 499,
'name' => 'Provincia Zudáñez'
],[
'state_id' => 499,
'name' => 'Sucre'
],[
'state_id' => 499,
'name' => 'Tarabuco'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
