<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CDStateSKCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 871,
'name' => 'Bukavu'
],[
'state_id' => 871,
'name' => 'Kabare'
],[
'state_id' => 871,
'name' => 'Uvira'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
