<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateMASCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 260,
'name' => 'Boradigah'
],[
'state_id' => 260,
'name' => 'Masally'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
