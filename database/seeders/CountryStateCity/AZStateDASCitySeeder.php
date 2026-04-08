<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateDASCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 266,
'name' => 'Verkhniy Dashkesan'
],[
'state_id' => 266,
'name' => 'Yukhary-Dashkesan'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
