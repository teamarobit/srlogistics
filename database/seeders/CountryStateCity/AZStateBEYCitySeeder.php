<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateBEYCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 259,
'name' => 'Beylagan'
],[
'state_id' => 259,
'name' => 'Birinci Aşıqlı'
],[
'state_id' => 259,
'name' => 'Dünyamalılar'
],[
'state_id' => 259,
'name' => 'Orjonikidze'
],[
'state_id' => 259,
'name' => 'Yuxarı Aran'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
