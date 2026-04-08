<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState30CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1105,
'name' => 'El Valle'
],[
'state_id' => 1105,
'name' => 'Guayabo Dulce'
],[
'state_id' => 1105,
'name' => 'Hato Mayor del Rey'
],[
'state_id' => 1105,
'name' => 'Sabana de la Mar'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
