<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStateRECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1508,
'name' => 'Champerico'
],[
'state_id' => 1508,
'name' => 'El Asintal'
],[
'state_id' => 1508,
'name' => 'Municipio de San Felipe'
],[
'state_id' => 1508,
'name' => 'Nuevo San Carlos'
],[
'state_id' => 1508,
'name' => 'Retalhuleu'
],[
'state_id' => 1508,
'name' => 'San Andrés Villa Seca'
],[
'state_id' => 1508,
'name' => 'San Felipe'
],[
'state_id' => 1508,
'name' => 'San Martín Zapotitlán'
],[
'state_id' => 1508,
'name' => 'San Sebastián'
],[
'state_id' => 1508,
'name' => 'Santa Cruz Muluá'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
