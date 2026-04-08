<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStateAVCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1515,
'name' => 'Cahabón'
],[
'state_id' => 1515,
'name' => 'Chahal Guatemala'
],[
'state_id' => 1515,
'name' => 'Chisec'
],[
'state_id' => 1515,
'name' => 'Cobán'
],[
'state_id' => 1515,
'name' => 'La Tinta'
],[
'state_id' => 1515,
'name' => 'Lanquín'
],[
'state_id' => 1515,
'name' => 'Panzós'
],[
'state_id' => 1515,
'name' => 'San Cristóbal Verapaz'
],[
'state_id' => 1515,
'name' => 'San Juan Chamelco'
],[
'state_id' => 1515,
'name' => 'San Pedro Carchá'
],[
'state_id' => 1515,
'name' => 'Santa Cruz Verapaz'
],[
'state_id' => 1515,
'name' => 'Senahú'
],[
'state_id' => 1515,
'name' => 'Tactic'
],[
'state_id' => 1515,
'name' => 'Tamahú'
],[
'state_id' => 1515,
'name' => 'Tucurú'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
