<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState13CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1115,
'name' => 'Concepción de La Vega'
],[
'state_id' => 1115,
'name' => 'Constanza'
],[
'state_id' => 1115,
'name' => 'Jarabacoa'
],[
'state_id' => 1115,
'name' => 'Jima Abajo'
],[
'state_id' => 1115,
'name' => 'Rincón'
],[
'state_id' => 1115,
'name' => 'Río Verde Arriba'
],[
'state_id' => 1115,
'name' => 'Tireo Arriba'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
