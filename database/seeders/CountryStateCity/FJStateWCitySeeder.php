<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FJStateWCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1241,
'name' => 'Ba'
],[
'state_id' => 1241,
'name' => 'Ba Province'
],[
'state_id' => 1241,
'name' => 'Lautoka'
],[
'state_id' => 1241,
'name' => 'Nadi'
],[
'state_id' => 1241,
'name' => 'Nandronga and Navosa Province'
],[
'state_id' => 1241,
'name' => 'Ra Province'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
