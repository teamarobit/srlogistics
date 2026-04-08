<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BOStatePCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 500,
'name' => 'Atocha'
],[
'state_id' => 500,
'name' => 'Betanzos'
],[
'state_id' => 500,
'name' => 'Colchani'
],[
'state_id' => 500,
'name' => 'Colquechaca'
],[
'state_id' => 500,
'name' => 'Enrique Baldivieso'
],[
'state_id' => 500,
'name' => 'Llallagua'
],[
'state_id' => 500,
'name' => 'Potosí'
],[
'state_id' => 500,
'name' => 'Provincia Alonzo de Ibáñez'
],[
'state_id' => 500,
'name' => 'Provincia Charcas'
],[
'state_id' => 500,
'name' => 'Provincia Chayanta'
],[
'state_id' => 500,
'name' => 'Provincia Daniel Campos'
],[
'state_id' => 500,
'name' => 'Provincia General Bilbao'
],[
'state_id' => 500,
'name' => 'Provincia Linares'
],[
'state_id' => 500,
'name' => 'Provincia Modesto Omiste'
],[
'state_id' => 500,
'name' => 'Provincia Nor Chichas'
],[
'state_id' => 500,
'name' => 'Provincia Nor Lípez'
],[
'state_id' => 500,
'name' => 'Provincia Quijarro'
],[
'state_id' => 500,
'name' => 'Provincia Rafael Bustillo'
],[
'state_id' => 500,
'name' => 'Provincia Saavedra'
],[
'state_id' => 500,
'name' => 'Provincia Sud Chichas'
],[
'state_id' => 500,
'name' => 'Provincia Sud Lípez'
],[
'state_id' => 500,
'name' => 'Provincia Tomás Frías'
],[
'state_id' => 500,
'name' => 'Santa Bárbara'
],[
'state_id' => 500,
'name' => 'Tupiza'
],[
'state_id' => 500,
'name' => 'Uyuni'
],[
'state_id' => 500,
'name' => 'Villazón'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
