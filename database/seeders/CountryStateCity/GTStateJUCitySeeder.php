<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStateJUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1517,
'name' => 'Agua Blanca'
],[
'state_id' => 1517,
'name' => 'Asunción Mita'
],[
'state_id' => 1517,
'name' => 'Atescatempa'
],[
'state_id' => 1517,
'name' => 'Comapa'
],[
'state_id' => 1517,
'name' => 'Conguaco'
],[
'state_id' => 1517,
'name' => 'El Adelanto'
],[
'state_id' => 1517,
'name' => 'El Progreso'
],[
'state_id' => 1517,
'name' => 'Jalpatagua'
],[
'state_id' => 1517,
'name' => 'Jerez'
],[
'state_id' => 1517,
'name' => 'Jutiapa'
],[
'state_id' => 1517,
'name' => 'Moyuta'
],[
'state_id' => 1517,
'name' => 'Municipio de Asunción Mita'
],[
'state_id' => 1517,
'name' => 'Pasaco'
],[
'state_id' => 1517,
'name' => 'Quesada'
],[
'state_id' => 1517,
'name' => 'San José Acatempa'
],[
'state_id' => 1517,
'name' => 'Santa Catarina Mita'
],[
'state_id' => 1517,
'name' => 'Yupiltepeque'
],[
'state_id' => 1517,
'name' => 'Zapotitlán'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
