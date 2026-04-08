<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CUState16CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 956,
'name' => 'Batabanó'
],[
'state_id' => 956,
'name' => 'Bejucal'
],[
'state_id' => 956,
'name' => 'Güines'
],[
'state_id' => 956,
'name' => 'Jamaica'
],[
'state_id' => 956,
'name' => 'Jaruco'
],[
'state_id' => 956,
'name' => 'La Salud'
],[
'state_id' => 956,
'name' => 'Madruga'
],[
'state_id' => 956,
'name' => 'Municipio de Güines'
],[
'state_id' => 956,
'name' => 'Municipio de Melena del Sur'
],[
'state_id' => 956,
'name' => 'Quivicán'
],[
'state_id' => 956,
'name' => 'San José de las Lajas'
],[
'state_id' => 956,
'name' => 'San Nicolás de Bari'
],[
'state_id' => 956,
'name' => 'Santa Cruz del Norte'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
