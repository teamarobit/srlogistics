<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateLAGCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 834,
'name' => 'Albania'
],[
'state_id' => 834,
'name' => 'Barrancas'
],[
'state_id' => 834,
'name' => 'Dibulla'
],[
'state_id' => 834,
'name' => 'Distracción'
],[
'state_id' => 834,
'name' => 'El Molino'
],[
'state_id' => 834,
'name' => 'Fonseca'
],[
'state_id' => 834,
'name' => 'Hatonuevo'
],[
'state_id' => 834,
'name' => 'La Jagua del Pilar'
],[
'state_id' => 834,
'name' => 'Maicao'
],[
'state_id' => 834,
'name' => 'Manaure'
],[
'state_id' => 834,
'name' => 'Riohacha'
],[
'state_id' => 834,
'name' => 'San Juan del Cesar'
],[
'state_id' => 834,
'name' => 'Uribia'
],[
'state_id' => 834,
'name' => 'Urumita'
],[
'state_id' => 834,
'name' => 'Villanueva'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
