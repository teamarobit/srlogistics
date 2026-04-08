<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStateTOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1507,
'name' => 'Momostenango'
],[
'state_id' => 1507,
'name' => 'Municipio de Momostenango'
],[
'state_id' => 1507,
'name' => 'Municipio de Santa María Chiquimula'
],[
'state_id' => 1507,
'name' => 'Municipio de Totonicapán'
],[
'state_id' => 1507,
'name' => 'San Andrés Xecul'
],[
'state_id' => 1507,
'name' => 'San Bartolo'
],[
'state_id' => 1507,
'name' => 'San Cristóbal Totonicapán'
],[
'state_id' => 1507,
'name' => 'San Francisco El Alto'
],[
'state_id' => 1507,
'name' => 'Santa Lucia La Reforma'
],[
'state_id' => 1507,
'name' => 'Santa María Chiquimula'
],[
'state_id' => 1507,
'name' => 'Totonicapán'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
