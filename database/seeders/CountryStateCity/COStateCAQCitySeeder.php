<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateCAQCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 836,
'name' => 'Albania'
],[
'state_id' => 836,
'name' => 'Belén de Los Andaquies'
],[
'state_id' => 836,
'name' => 'Cartagena del Chairá'
],[
'state_id' => 836,
'name' => 'Curillo'
],[
'state_id' => 836,
'name' => 'El Doncello'
],[
'state_id' => 836,
'name' => 'El Paujil'
],[
'state_id' => 836,
'name' => 'Florencia'
],[
'state_id' => 836,
'name' => 'La Montañita'
],[
'state_id' => 836,
'name' => 'Milán'
],[
'state_id' => 836,
'name' => 'Morelia'
],[
'state_id' => 836,
'name' => 'Puerto Rico'
],[
'state_id' => 836,
'name' => 'San José del Fragua'
],[
'state_id' => 836,
'name' => 'Solano'
],[
'state_id' => 836,
'name' => 'Valparaíso'
],[
'state_id' => 836,
'name' => 'San Vicente del Caguán'
],[
'state_id' => 836,
'name' => 'Solita'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
