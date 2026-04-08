<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CUState08CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 962,
'name' => 'Baraguá'
],[
'state_id' => 962,
'name' => 'Chambas'
],[
'state_id' => 962,
'name' => 'Ciego de Ávila'
],[
'state_id' => 962,
'name' => 'Ciro Redondo'
],[
'state_id' => 962,
'name' => 'Florencia'
],[
'state_id' => 962,
'name' => 'Morón'
],[
'state_id' => 962,
'name' => 'Municipio de Ciego de Ávila'
],[
'state_id' => 962,
'name' => 'Municipio de Morón'
],[
'state_id' => 962,
'name' => 'Primero de Enero'
],[
'state_id' => 962,
'name' => 'Venezuela'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
