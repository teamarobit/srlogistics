<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStatePECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1513,
'name' => 'Dolores'
],[
'state_id' => 1513,
'name' => 'Flores'
],[
'state_id' => 1513,
'name' => 'La Libertad'
],[
'state_id' => 1513,
'name' => 'Melchor de Mencos'
],[
'state_id' => 1513,
'name' => 'Municipio de Flores'
],[
'state_id' => 1513,
'name' => 'Municipio de Poptún'
],[
'state_id' => 1513,
'name' => 'Municipio de San Andrés'
],[
'state_id' => 1513,
'name' => 'Municipio de San Benito'
],[
'state_id' => 1513,
'name' => 'Municipio de San Francisco'
],[
'state_id' => 1513,
'name' => 'Municipio de Santa Ana'
],[
'state_id' => 1513,
'name' => 'Municipio de Sayaxché'
],[
'state_id' => 1513,
'name' => 'Poptún'
],[
'state_id' => 1513,
'name' => 'San Andrés'
],[
'state_id' => 1513,
'name' => 'San Benito'
],[
'state_id' => 1513,
'name' => 'San Francisco'
],[
'state_id' => 1513,
'name' => 'San José'
],[
'state_id' => 1513,
'name' => 'San Luis'
],[
'state_id' => 1513,
'name' => 'Santa Ana'
],[
'state_id' => 1513,
'name' => 'Sayaxché'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
