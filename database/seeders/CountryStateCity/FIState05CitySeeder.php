<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FIState05CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1256,
'name' => 'Hyrynsalmi'
],[
'state_id' => 1256,
'name' => 'Kajaani'
],[
'state_id' => 1256,
'name' => 'Kuhmo'
],[
'state_id' => 1256,
'name' => 'Paltamo'
],[
'state_id' => 1256,
'name' => 'Puolanka'
],[
'state_id' => 1256,
'name' => 'Ristijärvi'
],[
'state_id' => 1256,
'name' => 'Sotkamo'
],[
'state_id' => 1256,
'name' => 'Suomussalmi'
],[
'state_id' => 1256,
'name' => 'Vaala'
],[
'state_id' => 1256,
'name' => 'Vuokatti'
],[
'state_id' => 1256,
'name' => 'Vuolijoki'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
