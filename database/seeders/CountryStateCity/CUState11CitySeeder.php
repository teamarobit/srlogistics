<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CUState11CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 959,
'name' => 'Banes'
],[
'state_id' => 959,
'name' => 'Cacocum'
],[
'state_id' => 959,
'name' => 'Cueto'
],[
'state_id' => 959,
'name' => 'Gibara'
],[
'state_id' => 959,
'name' => 'Holguín'
],[
'state_id' => 959,
'name' => 'Jobabo'
],[
'state_id' => 959,
'name' => 'Moa'
],[
'state_id' => 959,
'name' => 'Municipio de Banes'
],[
'state_id' => 959,
'name' => 'Municipio de Holguín'
],[
'state_id' => 959,
'name' => 'Sagua de Tánamo'
],[
'state_id' => 959,
'name' => 'San Germán'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
