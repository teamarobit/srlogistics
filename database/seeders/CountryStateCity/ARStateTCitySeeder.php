<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 174,
'name' => 'Aguilares'
],[
'state_id' => 174,
'name' => 'Alderetes'
],[
'state_id' => 174,
'name' => 'Bella Vista'
],[
'state_id' => 174,
'name' => 'Burruyacú'
],[
'state_id' => 174,
'name' => 'Departamento de Burruyacú'
],[
'state_id' => 174,
'name' => 'Departamento de Capital'
],[
'state_id' => 174,
'name' => 'Departamento de Cruz Alta'
],[
'state_id' => 174,
'name' => 'Departamento de Famaillá'
],[
'state_id' => 174,
'name' => 'Departamento de Graneros'
],[
'state_id' => 174,
'name' => 'Departamento de La Cocha'
],[
'state_id' => 174,
'name' => 'Departamento de Lules'
],[
'state_id' => 174,
'name' => 'Departamento de Monteros'
],[
'state_id' => 174,
'name' => 'Departamento de Río Chico'
],[
'state_id' => 174,
'name' => 'Departamento de Simoca'
],[
'state_id' => 174,
'name' => 'Departamento de Trancas'
],[
'state_id' => 174,
'name' => 'Departamento de Yerba Buena'
],[
'state_id' => 174,
'name' => 'Famaillá'
],[
'state_id' => 174,
'name' => 'Graneros'
],[
'state_id' => 174,
'name' => 'La Cocha'
],[
'state_id' => 174,
'name' => 'Monteros'
],[
'state_id' => 174,
'name' => 'San Miguel de Tucumán'
],[
'state_id' => 174,
'name' => 'Simoca'
],[
'state_id' => 174,
'name' => 'Tafí Viejo'
],[
'state_id' => 174,
'name' => 'Tafí del Valle'
],[
'state_id' => 174,
'name' => 'Trancas'
],[
'state_id' => 174,
'name' => 'Yerba Buena'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
