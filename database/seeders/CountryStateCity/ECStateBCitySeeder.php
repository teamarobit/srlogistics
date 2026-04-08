<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ECStateBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1143,
'name' => 'Guaranda'
],[
'state_id' => 1143,
'name' => 'San Miguel'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
