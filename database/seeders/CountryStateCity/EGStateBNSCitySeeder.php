<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateBNSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1160,
'name' => 'Al Fashn'
],[
'state_id' => 1160,
'name' => 'Banī Suwayf'
],[
'state_id' => 1160,
'name' => 'Būsh'
],[
'state_id' => 1160,
'name' => 'Sumusţā as Sulţānī'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
