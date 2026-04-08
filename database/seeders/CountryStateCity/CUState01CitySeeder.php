<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CUState01CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 957,
'name' => 'Consolación del Sur'
],[
'state_id' => 957,
'name' => 'Guane'
],[
'state_id' => 957,
'name' => 'Los Palacios'
],[
'state_id' => 957,
'name' => 'Mantua'
],[
'state_id' => 957,
'name' => 'Minas de Matahambre'
],[
'state_id' => 957,
'name' => 'Municipio de Consolación del Sur'
],[
'state_id' => 957,
'name' => 'Municipio de Guane'
],[
'state_id' => 957,
'name' => 'Municipio de La Palma'
],[
'state_id' => 957,
'name' => 'Municipio de Los Palacios'
],[
'state_id' => 957,
'name' => 'Pinar del Río'
],[
'state_id' => 957,
'name' => 'Puerto Esperanza'
],[
'state_id' => 957,
'name' => 'San Diego de Los Baños'
],[
'state_id' => 957,
'name' => 'San Luis'
],[
'state_id' => 957,
'name' => 'Viñales'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
