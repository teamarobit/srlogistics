<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ECStateGCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1137,
'name' => 'Alfredo Baquerizo Moreno'
],[
'state_id' => 1137,
'name' => 'Balzar'
],[
'state_id' => 1137,
'name' => 'Baláo'
],[
'state_id' => 1137,
'name' => 'Colimes'
],[
'state_id' => 1137,
'name' => 'Coronel Marcelino Maridueña'
],[
'state_id' => 1137,
'name' => 'El Triunfo'
],[
'state_id' => 1137,
'name' => 'Eloy Alfaro'
],[
'state_id' => 1137,
'name' => 'Guayaquil'
],[
'state_id' => 1137,
'name' => 'Lomas de Sargentillo'
],[
'state_id' => 1137,
'name' => 'Milagro'
],[
'state_id' => 1137,
'name' => 'Naranjal'
],[
'state_id' => 1137,
'name' => 'Naranjito'
],[
'state_id' => 1137,
'name' => 'Palestina'
],[
'state_id' => 1137,
'name' => 'Pedro Carbo'
],[
'state_id' => 1137,
'name' => 'Playas'
],[
'state_id' => 1137,
'name' => 'Samborondón'
],[
'state_id' => 1137,
'name' => 'Santa Lucía'
],[
'state_id' => 1137,
'name' => 'Velasco Ibarra'
],[
'state_id' => 1137,
'name' => 'Yaguachi Nuevo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
