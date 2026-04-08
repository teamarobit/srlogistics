<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateSUZCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1163,
'name' => 'Ain Sukhna'
],[
'state_id' => 1163,
'name' => 'Suez'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
