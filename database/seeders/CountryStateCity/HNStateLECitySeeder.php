<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HNStateLECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1606,
'name' => 'Belén'
],[
'state_id' => 1606,
'name' => 'Candelaria'
],[
'state_id' => 1606,
'name' => 'Cololaca'
],[
'state_id' => 1606,
'name' => 'El Achiotal'
],[
'state_id' => 1606,
'name' => 'Erandique'
],[
'state_id' => 1606,
'name' => 'Gracias'
],[
'state_id' => 1606,
'name' => 'Gualcince'
],[
'state_id' => 1606,
'name' => 'Guarita'
],[
'state_id' => 1606,
'name' => 'La Campa'
],[
'state_id' => 1606,
'name' => 'La Iguala'
],[
'state_id' => 1606,
'name' => 'La Libertad'
],[
'state_id' => 1606,
'name' => 'La Unión'
],[
'state_id' => 1606,
'name' => 'La Virtud'
],[
'state_id' => 1606,
'name' => 'Las Flores'
],[
'state_id' => 1606,
'name' => 'Las Tejeras'
],[
'state_id' => 1606,
'name' => 'Lepaera'
],[
'state_id' => 1606,
'name' => 'Mapulaca'
],[
'state_id' => 1606,
'name' => 'Piraera'
],[
'state_id' => 1606,
'name' => 'San Andrés'
],[
'state_id' => 1606,
'name' => 'San Francisco'
],[
'state_id' => 1606,
'name' => 'San Juan Guarita'
],[
'state_id' => 1606,
'name' => 'San Manuel Colohete'
],[
'state_id' => 1606,
'name' => 'San Marcos de Caiquin'
],[
'state_id' => 1606,
'name' => 'San Rafael'
],[
'state_id' => 1606,
'name' => 'San Sebastián'
],[
'state_id' => 1606,
'name' => 'Santa Cruz'
],[
'state_id' => 1606,
'name' => 'Talgua'
],[
'state_id' => 1606,
'name' => 'Tambla'
],[
'state_id' => 1606,
'name' => 'Taragual'
],[
'state_id' => 1606,
'name' => 'Tomalá'
],[
'state_id' => 1606,
'name' => 'Valladolid'
],[
'state_id' => 1606,
'name' => 'Virginia'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
