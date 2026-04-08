<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState22CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1097,
'name' => 'Bohechío'
],[
'state_id' => 1097,
'name' => 'Cercado Abajo'
],[
'state_id' => 1097,
'name' => 'El Cercado'
],[
'state_id' => 1097,
'name' => 'Juan de Herrera'
],[
'state_id' => 1097,
'name' => 'Las Matas de Farfán'
],[
'state_id' => 1097,
'name' => 'Matayaya'
],[
'state_id' => 1097,
'name' => 'Pedro Corto'
],[
'state_id' => 1097,
'name' => 'San Juan de la Maguana'
],[
'state_id' => 1097,
'name' => 'Vallejuelo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
