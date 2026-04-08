<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FJStateECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1250,
'name' => 'Kadavu Province'
],[
'state_id' => 1250,
'name' => 'Lau Province'
],[
'state_id' => 1250,
'name' => 'Levuka'
],[
'state_id' => 1250,
'name' => 'Lomaiviti Province'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
