<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStateQCCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1501,
'name' => 'Canillá'
],[
'state_id' => 1501,
'name' => 'Chajul'
],[
'state_id' => 1501,
'name' => 'Chicamán'
],[
'state_id' => 1501,
'name' => 'Chichicastenango'
],[
'state_id' => 1501,
'name' => 'Chiché'
],[
'state_id' => 1501,
'name' => 'Chinique'
],[
'state_id' => 1501,
'name' => 'Cunén'
],[
'state_id' => 1501,
'name' => 'Joyabaj'
],[
'state_id' => 1501,
'name' => 'Municipio de Canillá'
],[
'state_id' => 1501,
'name' => 'Municipio de Chajul'
],[
'state_id' => 1501,
'name' => 'Municipio de Chicaman'
],[
'state_id' => 1501,
'name' => 'Municipio de Chichicastenango'
],[
'state_id' => 1501,
'name' => 'Municipio de Chiché'
],[
'state_id' => 1501,
'name' => 'Municipio de Chinique'
],[
'state_id' => 1501,
'name' => 'Municipio de Cunén'
],[
'state_id' => 1501,
'name' => 'Municipio de Ixcan'
],[
'state_id' => 1501,
'name' => 'Municipio de Joyabaj'
],[
'state_id' => 1501,
'name' => 'Municipio de Pachalum'
],[
'state_id' => 1501,
'name' => 'Municipio de Patzité'
],[
'state_id' => 1501,
'name' => 'Municipio de San Andrés Sajcabajá'
],[
'state_id' => 1501,
'name' => 'Municipio de San Antonio Ilotenango'
],[
'state_id' => 1501,
'name' => 'Municipio de San Juan Cotzal'
],[
'state_id' => 1501,
'name' => 'Municipio de San Pedro Jocopilas'
],[
'state_id' => 1501,
'name' => 'Municipio de Uspantán'
],[
'state_id' => 1501,
'name' => 'Municipio de Zacualpa'
],[
'state_id' => 1501,
'name' => 'Nebaj'
],[
'state_id' => 1501,
'name' => 'Pachalum'
],[
'state_id' => 1501,
'name' => 'Patzité'
],[
'state_id' => 1501,
'name' => 'Playa Grande'
],[
'state_id' => 1501,
'name' => 'Sacapulas'
],[
'state_id' => 1501,
'name' => 'San Andrés Sajcabajá'
],[
'state_id' => 1501,
'name' => 'San Antonio Ilotenango'
],[
'state_id' => 1501,
'name' => 'San Bartolomé Jocotenango'
],[
'state_id' => 1501,
'name' => 'San Juan Cotzal'
],[
'state_id' => 1501,
'name' => 'San Luis Ixcán'
],[
'state_id' => 1501,
'name' => 'San Pédro Jocopilas'
],[
'state_id' => 1501,
'name' => 'Santa Cruz del Quiché'
],[
'state_id' => 1501,
'name' => 'Uspantán'
],[
'state_id' => 1501,
'name' => 'Zacualpa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
