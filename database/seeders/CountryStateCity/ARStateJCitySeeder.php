<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateJCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 171,
'name' => 'Albardón'
],[
'state_id' => 171,
'name' => 'Calingasta'
],[
'state_id' => 171,
'name' => 'Caucete'
],[
'state_id' => 171,
'name' => 'Chimbas'
],[
'state_id' => 171,
'name' => 'Departamento de Albardón'
],[
'state_id' => 171,
'name' => 'Departamento de Angaco'
],[
'state_id' => 171,
'name' => 'Departamento de Calingasta'
],[
'state_id' => 171,
'name' => 'Departamento de Capital'
],[
'state_id' => 171,
'name' => 'Departamento de Caucete'
],[
'state_id' => 171,
'name' => 'Departamento de Chimbas'
],[
'state_id' => 171,
'name' => 'Departamento de Iglesia'
],[
'state_id' => 171,
'name' => 'Departamento de Jáchal'
],[
'state_id' => 171,
'name' => 'Departamento de Nueve de Julio'
],[
'state_id' => 171,
'name' => 'Departamento de Rawson'
],[
'state_id' => 171,
'name' => 'Departamento de Rivadavia'
],[
'state_id' => 171,
'name' => 'Departamento de San Martín'
],[
'state_id' => 171,
'name' => 'Departamento de Santa Lucía'
],[
'state_id' => 171,
'name' => 'Departamento de Sarmiento'
],[
'state_id' => 171,
'name' => 'Departamento de Ullúm'
],[
'state_id' => 171,
'name' => 'Departamento de Zonda'
],[
'state_id' => 171,
'name' => 'Nueve de Julio'
],[
'state_id' => 171,
'name' => 'Pocito'
],[
'state_id' => 171,
'name' => 'San Agustín de Valle Fértil'
],[
'state_id' => 171,
'name' => 'San José de Jáchal'
],[
'state_id' => 171,
'name' => 'San Juan'
],[
'state_id' => 171,
'name' => 'San Martín'
],[
'state_id' => 171,
'name' => 'Santa Lucía'
],[
'state_id' => 171,
'name' => 'Villa Basilio Nievas'
],[
'state_id' => 171,
'name' => 'Villa Paula de Sarmiento'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
