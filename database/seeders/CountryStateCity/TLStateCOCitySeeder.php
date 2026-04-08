<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TLStateCOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1124,
'name' => 'Fatumean'
],[
'state_id' => 1124,
'name' => 'Fohorem'
],[
'state_id' => 1124,
'name' => 'Maucatar'
],[
'state_id' => 1124,
'name' => 'Suai'
],[
'state_id' => 1124,
'name' => 'Tilomar'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
