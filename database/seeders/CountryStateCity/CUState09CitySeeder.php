<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CUState09CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 966,
'name' => 'Camagüey'
],[
'state_id' => 966,
'name' => 'El Caney'
],[
'state_id' => 966,
'name' => 'Esmeralda'
],[
'state_id' => 966,
'name' => 'Florida'
],[
'state_id' => 966,
'name' => 'Guáimaro'
],[
'state_id' => 966,
'name' => 'Jimaguayú'
],[
'state_id' => 966,
'name' => 'Minas'
],[
'state_id' => 966,
'name' => 'Municipio de Florida'
],[
'state_id' => 966,
'name' => 'Municipio de Nuevitas'
],[
'state_id' => 966,
'name' => 'Nuevitas'
],[
'state_id' => 966,
'name' => 'Santa Cruz del Sur'
],[
'state_id' => 966,
'name' => 'Sibanicú'
],[
'state_id' => 966,
'name' => 'Vertientes'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
