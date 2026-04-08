<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class SVStateCHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1183,
'name' => 'Chalatenango'
],[
'state_id' => 1183,
'name' => 'Nueva Concepción'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
