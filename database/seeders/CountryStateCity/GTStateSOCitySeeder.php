<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStateSOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1505,
'name' => 'Concepción'
],[
'state_id' => 1505,
'name' => 'Municipio de Nahualá'
],[
'state_id' => 1505,
'name' => 'Municipio de Panajachel'
],[
'state_id' => 1505,
'name' => 'Municipio de Santa Catarina Palopó'
],[
'state_id' => 1505,
'name' => 'Municipio de Santa Cruz La Laguna'
],[
'state_id' => 1505,
'name' => 'Nahualá'
],[
'state_id' => 1505,
'name' => 'Panajachel'
],[
'state_id' => 1505,
'name' => 'San Andrés Semetabaj'
],[
'state_id' => 1505,
'name' => 'San Antonio Palopó'
],[
'state_id' => 1505,
'name' => 'San José Chacayá'
],[
'state_id' => 1505,
'name' => 'San Juan La Laguna'
],[
'state_id' => 1505,
'name' => 'San Lucas Tolimán'
],[
'state_id' => 1505,
'name' => 'San Marcos La Laguna'
],[
'state_id' => 1505,
'name' => 'San Pablo La Laguna'
],[
'state_id' => 1505,
'name' => 'San Pedro La Laguna'
],[
'state_id' => 1505,
'name' => 'Santa Catarina Ixtahuacán'
],[
'state_id' => 1505,
'name' => 'Santa Catarina Palopó'
],[
'state_id' => 1505,
'name' => 'Santa Clara La Laguna'
],[
'state_id' => 1505,
'name' => 'Santa Cruz La Laguna'
],[
'state_id' => 1505,
'name' => 'Santa Lucía Utatlán'
],[
'state_id' => 1505,
'name' => 'Santa María Visitación'
],[
'state_id' => 1505,
'name' => 'Santiago Atitlán'
],[
'state_id' => 1505,
'name' => 'Sololá'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
