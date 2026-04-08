<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStateIZCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1503,
'name' => 'El Estor'
],[
'state_id' => 1503,
'name' => 'Los Amates'
],[
'state_id' => 1503,
'name' => 'Lívingston'
],[
'state_id' => 1503,
'name' => 'Morales'
],[
'state_id' => 1503,
'name' => 'Municipio de Morales'
],[
'state_id' => 1503,
'name' => 'Municipio de Puerto Barrios'
],[
'state_id' => 1503,
'name' => 'Puerto Barrios'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
