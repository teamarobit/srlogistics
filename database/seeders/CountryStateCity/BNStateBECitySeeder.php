<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BNStateBECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 552,
'name' => 'Kuala Belait'
],[
'state_id' => 552,
'name' => 'Seria'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
