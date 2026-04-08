<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CRStateCCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 895,
'name' => 'Alvarado'
],[
'state_id' => 895,
'name' => 'Cartago'
],[
'state_id' => 895,
'name' => 'Concepción'
],[
'state_id' => 895,
'name' => 'Cot'
],[
'state_id' => 895,
'name' => 'El Guarco'
],[
'state_id' => 895,
'name' => 'Jiménez'
],[
'state_id' => 895,
'name' => 'La Suiza'
],[
'state_id' => 895,
'name' => 'La Unión'
],[
'state_id' => 895,
'name' => 'Oreamuno'
],[
'state_id' => 895,
'name' => 'Orosí'
],[
'state_id' => 895,
'name' => 'Pacayas'
],[
'state_id' => 895,
'name' => 'Paraíso'
],[
'state_id' => 895,
'name' => 'Pejibaye'
],[
'state_id' => 895,
'name' => 'San Diego'
],[
'state_id' => 895,
'name' => 'Tobosi'
],[
'state_id' => 895,
'name' => 'Tres Ríos'
],[
'state_id' => 895,
'name' => 'Tucurrique'
],[
'state_id' => 895,
'name' => 'Turrialba'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
