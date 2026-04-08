<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ECStateDCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1149,
'name' => 'Boca Suno'
],[
'state_id' => 1149,
'name' => 'Francisco de Orellana Canton'
],[
'state_id' => 1149,
'name' => 'Loreto Canton'
],[
'state_id' => 1149,
'name' => 'Puerto Francisco de Orellana'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
