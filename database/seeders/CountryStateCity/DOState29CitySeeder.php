<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState29CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1110,
'name' => 'Bayaguana'
],[
'state_id' => 1110,
'name' => 'Don Juan'
],[
'state_id' => 1110,
'name' => 'Esperalvillo'
],[
'state_id' => 1110,
'name' => 'Gonzalo'
],[
'state_id' => 1110,
'name' => 'Los Botados'
],[
'state_id' => 1110,
'name' => 'Majagual'
],[
'state_id' => 1110,
'name' => 'Monte Plata'
],[
'state_id' => 1110,
'name' => 'Sabana Grande de Boyá'
],[
'state_id' => 1110,
'name' => 'Yamasá'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
