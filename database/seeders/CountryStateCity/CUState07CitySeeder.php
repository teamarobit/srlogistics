<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CUState07CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 954,
'name' => 'Cabaiguán'
],[
'state_id' => 954,
'name' => 'Condado'
],[
'state_id' => 954,
'name' => 'Fomento'
],[
'state_id' => 954,
'name' => 'Guayos'
],[
'state_id' => 954,
'name' => 'Jatibonico'
],[
'state_id' => 954,
'name' => 'La Sierpe'
],[
'state_id' => 954,
'name' => 'Municipio de Cabaiguán'
],[
'state_id' => 954,
'name' => 'Municipio de Jatibonico'
],[
'state_id' => 954,
'name' => 'Municipio de Sancti Spíritus'
],[
'state_id' => 954,
'name' => 'Municipio de Trinidad'
],[
'state_id' => 954,
'name' => 'Sancti Spíritus'
],[
'state_id' => 954,
'name' => 'Topes de Collantes'
],[
'state_id' => 954,
'name' => 'Trinidad'
],[
'state_id' => 954,
'name' => 'Yaguajay'
],[
'state_id' => 954,
'name' => 'Zaza del Medio'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
