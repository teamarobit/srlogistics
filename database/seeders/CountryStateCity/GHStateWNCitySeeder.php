<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GHStateWNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1455,
'name' => 'Aowin'
],[
'state_id' => 1455,
'name' => 'Bia East'
],[
'state_id' => 1455,
'name' => 'Bia West'
],[
'state_id' => 1455,
'name' => 'Bibiani-Anhwiaso-Bekwai'
],[
'state_id' => 1455,
'name' => 'Bodi'
],[
'state_id' => 1455,
'name' => 'Juaboso'
],[
'state_id' => 1455,
'name' => 'Sefwi-Akontombra'
],[
'state_id' => 1455,
'name' => 'Sefwi-Wiawso'
],[
'state_id' => 1455,
'name' => 'Suaman'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
