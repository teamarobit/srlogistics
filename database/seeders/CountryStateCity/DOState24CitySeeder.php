<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState24CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1087,
'name' => 'Cevicos'
],[
'state_id' => 1087,
'name' => 'Cotuí'
],[
'state_id' => 1087,
'name' => 'Fantino'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
