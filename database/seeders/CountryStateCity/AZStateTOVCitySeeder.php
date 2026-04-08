<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateTOVCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 238,
'name' => 'Dondar Quşçu'
],[
'state_id' => 238,
'name' => 'Qaraxanlı'
],[
'state_id' => 238,
'name' => 'Tovuz'
],[
'state_id' => 238,
'name' => 'Yanıqlı'
],[
'state_id' => 238,
'name' => 'Çatax'
],[
'state_id' => 238,
'name' => 'Çobansığnaq'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
