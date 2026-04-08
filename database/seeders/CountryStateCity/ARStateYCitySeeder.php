<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateYCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 182,
'name' => 'Abra Pampa'
],[
'state_id' => 182,
'name' => 'Caimancito'
],[
'state_id' => 182,
'name' => 'Calilegua'
],[
'state_id' => 182,
'name' => 'Departamento de Cochinoca'
],[
'state_id' => 182,
'name' => 'Departamento de Rinconada'
],[
'state_id' => 182,
'name' => 'Departamento de Tumbaya'
],[
'state_id' => 182,
'name' => 'El Aguilar'
],[
'state_id' => 182,
'name' => 'Fraile Pintado'
],[
'state_id' => 182,
'name' => 'Humahuaca'
],[
'state_id' => 182,
'name' => 'Ingenio La Esperanza'
],[
'state_id' => 182,
'name' => 'La Mendieta'
],[
'state_id' => 182,
'name' => 'La Quiaca'
],[
'state_id' => 182,
'name' => 'Libertador General San Martín'
],[
'state_id' => 182,
'name' => 'Maimará'
],[
'state_id' => 182,
'name' => 'Palma Sola'
],[
'state_id' => 182,
'name' => 'Palpalá'
],[
'state_id' => 182,
'name' => 'San Pedro de Jujuy'
],[
'state_id' => 182,
'name' => 'San Salvador de Jujuy'
],[
'state_id' => 182,
'name' => 'Santa Clara'
],[
'state_id' => 182,
'name' => 'Tilcara'
],[
'state_id' => 182,
'name' => 'Yuto'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
