<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CUState14CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 965,
'name' => 'Baracoa'
],[
'state_id' => 965,
'name' => 'Guantánamo'
],[
'state_id' => 965,
'name' => 'Maisí'
],[
'state_id' => 965,
'name' => 'Municipio de Guantánamo'
],[
'state_id' => 965,
'name' => 'Río Guayabal de Yateras'
],[
'state_id' => 965,
'name' => 'San Antonio del Sur'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
