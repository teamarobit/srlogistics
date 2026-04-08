<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateCESCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 844,
'name' => 'Aguachica'
],[
'state_id' => 844,
'name' => 'Agustín Codazzi'
],[
'state_id' => 844,
'name' => 'Astrea'
],[
'state_id' => 844,
'name' => 'Becerril'
],[
'state_id' => 844,
'name' => 'Chimichagua'
],[
'state_id' => 844,
'name' => 'Chiriguaná'
],[
'state_id' => 844,
'name' => 'Curumaní'
],[
'state_id' => 844,
'name' => 'El Copey'
],[
'state_id' => 844,
'name' => 'El Paso'
],[
'state_id' => 844,
'name' => 'Gamarra'
],[
'state_id' => 844,
'name' => 'González'
],[
'state_id' => 844,
'name' => 'La Gloria'
],[
'state_id' => 844,
'name' => 'La Jagua de Ibirico'
],[
'state_id' => 844,
'name' => 'La Paz'
],[
'state_id' => 844,
'name' => 'Manaure Balcón del Cesar'
],[
'state_id' => 844,
'name' => 'Pailitas'
],[
'state_id' => 844,
'name' => 'Pelaya'
],[
'state_id' => 844,
'name' => 'Río de Oro'
],[
'state_id' => 844,
'name' => 'San Alberto'
],[
'state_id' => 844,
'name' => 'San Diego'
],[
'state_id' => 844,
'name' => 'San Martín'
],[
'state_id' => 844,
'name' => 'Tamalameque'
],[
'state_id' => 844,
'name' => 'Valledupar'
],[
'state_id' => 844,
'name' => 'Bosconia'
],[
'state_id' => 844,
'name' => 'Pueblo Bello'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
