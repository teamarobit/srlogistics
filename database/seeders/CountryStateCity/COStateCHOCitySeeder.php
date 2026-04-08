<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateCHOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 821,
'name' => 'Acandí'
],[
'state_id' => 821,
'name' => 'Alto Baudó'
],[
'state_id' => 821,
'name' => 'Atrato'
],[
'state_id' => 821,
'name' => 'Bagadó'
],[
'state_id' => 821,
'name' => 'Bahía Solano'
],[
'state_id' => 821,
'name' => 'Bajo Baudó'
],[
'state_id' => 821,
'name' => 'Bojayá'
],[
'state_id' => 821,
'name' => 'Carmen del Darien'
],[
'state_id' => 821,
'name' => 'Condoto'
],[
'state_id' => 821,
'name' => 'Cértegui'
],[
'state_id' => 821,
'name' => 'El Cantón de San Pablo'
],[
'state_id' => 821,
'name' => 'El Carmen de Atrato'
],[
'state_id' => 821,
'name' => 'Istmina'
],[
'state_id' => 821,
'name' => 'Juradó'
],[
'state_id' => 821,
'name' => 'Lloró'
],[
'state_id' => 821,
'name' => 'Medio Atrato'
],[
'state_id' => 821,
'name' => 'Medio Baudó'
],[
'state_id' => 821,
'name' => 'Medio San Juan'
],[
'state_id' => 821,
'name' => 'Nuquí'
],[
'state_id' => 821,
'name' => 'Nóvita'
],[
'state_id' => 821,
'name' => 'Quibdó'
],[
'state_id' => 821,
'name' => 'Riosucio'
],[
'state_id' => 821,
'name' => 'Río Iro'
],[
'state_id' => 821,
'name' => 'Río Quito'
],[
'state_id' => 821,
'name' => 'San José del Palmar'
],[
'state_id' => 821,
'name' => 'Litoral del San Juan'
],[
'state_id' => 821,
'name' => 'Sipí'
],[
'state_id' => 821,
'name' => 'Tadó'
],[
'state_id' => 821,
'name' => 'Unguía'
],[
'state_id' => 821,
'name' => 'Unión Panamericana'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
