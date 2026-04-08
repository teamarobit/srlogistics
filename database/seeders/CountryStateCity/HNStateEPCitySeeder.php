<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HNStateEPCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1595,
'name' => 'Alauca'
],[
'state_id' => 1595,
'name' => 'Araulí'
],[
'state_id' => 1595,
'name' => 'Cuyalí'
],[
'state_id' => 1595,
'name' => 'Danlí'
],[
'state_id' => 1595,
'name' => 'El Benque'
],[
'state_id' => 1595,
'name' => 'El Chichicaste'
],[
'state_id' => 1595,
'name' => 'El Obraje'
],[
'state_id' => 1595,
'name' => 'El Paraíso'
],[
'state_id' => 1595,
'name' => 'Güinope'
],[
'state_id' => 1595,
'name' => 'Jacaleapa'
],[
'state_id' => 1595,
'name' => 'Jutiapa'
],[
'state_id' => 1595,
'name' => 'Las Trojes'
],[
'state_id' => 1595,
'name' => 'Las Ánimas'
],[
'state_id' => 1595,
'name' => 'Liure'
],[
'state_id' => 1595,
'name' => 'Morocelí'
],[
'state_id' => 1595,
'name' => 'Municipio de Texiguat'
],[
'state_id' => 1595,
'name' => 'Ojo de Agua'
],[
'state_id' => 1595,
'name' => 'Oropolí'
],[
'state_id' => 1595,
'name' => 'Potrerillos'
],[
'state_id' => 1595,
'name' => 'Quebrada Larga'
],[
'state_id' => 1595,
'name' => 'San Antonio de Flores'
],[
'state_id' => 1595,
'name' => 'San Diego'
],[
'state_id' => 1595,
'name' => 'San Lucas'
],[
'state_id' => 1595,
'name' => 'San Matías'
],[
'state_id' => 1595,
'name' => 'Santa Cruz'
],[
'state_id' => 1595,
'name' => 'Soledad'
],[
'state_id' => 1595,
'name' => 'Teupasenti'
],[
'state_id' => 1595,
'name' => 'Texíguat'
],[
'state_id' => 1595,
'name' => 'Trojes'
],[
'state_id' => 1595,
'name' => 'Vado Ancho'
],[
'state_id' => 1595,
'name' => 'Yauyupe'
],[
'state_id' => 1595,
'name' => 'Yuscarán'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
