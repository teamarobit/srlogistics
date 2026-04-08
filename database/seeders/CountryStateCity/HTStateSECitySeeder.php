<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HTStateSECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1590,
'name' => 'Anse-à-Pitre'
],[
'state_id' => 1590,
'name' => 'Arrondissement de Bainet'
],[
'state_id' => 1590,
'name' => 'Arrondissement de Jacmel'
],[
'state_id' => 1590,
'name' => 'Belle-Anse'
],[
'state_id' => 1590,
'name' => 'Cayes-Jacmel'
],[
'state_id' => 1590,
'name' => 'Jacmel'
],[
'state_id' => 1590,
'name' => 'Kotdefè'
],[
'state_id' => 1590,
'name' => 'Marigot'
],[
'state_id' => 1590,
'name' => 'Thiotte'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
