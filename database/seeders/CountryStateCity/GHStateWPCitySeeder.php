<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GHStateWPCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1441,
'name' => 'Aboso'
],[
'state_id' => 1441,
'name' => 'Axim'
],[
'state_id' => 1441,
'name' => 'Bibiani'
],[
'state_id' => 1441,
'name' => 'Prestea'
],[
'state_id' => 1441,
'name' => 'Sekondi-Takoradi'
],[
'state_id' => 1441,
'name' => 'Shama Junction'
],[
'state_id' => 1441,
'name' => 'Takoradi'
],[
'state_id' => 1441,
'name' => 'Tarkwa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
