<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateAMACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 840,
'name' => 'El Encanto'
],[
'state_id' => 840,
'name' => 'La Chorrera'
],[
'state_id' => 840,
'name' => 'La Pedrera'
],[
'state_id' => 840,
'name' => 'La Victoria'
],[
'state_id' => 840,
'name' => 'Leticia'
],[
'state_id' => 840,
'name' => 'Miriti - Paraná'
],[
'state_id' => 840,
'name' => 'Puerto Alegría'
],[
'state_id' => 840,
'name' => 'Puerto Arica'
],[
'state_id' => 840,
'name' => 'Puerto Nariño'
],[
'state_id' => 840,
'name' => 'Puerto Santander'
],[
'state_id' => 840,
'name' => 'Tarapacá'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
