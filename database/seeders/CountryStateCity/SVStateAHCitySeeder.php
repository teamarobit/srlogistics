<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class SVStateAHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1191,
'name' => 'Ahuachapán'
],[
'state_id' => 1191,
'name' => 'Atiquizaya'
],[
'state_id' => 1191,
'name' => 'Concepción de Ataco'
],[
'state_id' => 1191,
'name' => 'Guaymango'
],[
'state_id' => 1191,
'name' => 'Jujutla'
],[
'state_id' => 1191,
'name' => 'San Francisco Menéndez'
],[
'state_id' => 1191,
'name' => 'Tacuba'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
