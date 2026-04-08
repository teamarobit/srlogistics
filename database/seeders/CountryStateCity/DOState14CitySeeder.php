<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState14CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1093,
'name' => 'Arroyo Salado'
],[
'state_id' => 1093,
'name' => 'Cabrera'
],[
'state_id' => 1093,
'name' => 'El Factor'
],[
'state_id' => 1093,
'name' => 'La Entrada'
],[
'state_id' => 1093,
'name' => 'Nagua'
],[
'state_id' => 1093,
'name' => 'Río San Juan'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
