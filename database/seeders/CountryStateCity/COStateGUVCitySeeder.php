<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateGUVCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 833,
'name' => 'Calamar'
],[
'state_id' => 833,
'name' => 'El Retorno'
],[
'state_id' => 833,
'name' => 'Miraflores'
],[
'state_id' => 833,
'name' => 'San José del Guaviare'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
