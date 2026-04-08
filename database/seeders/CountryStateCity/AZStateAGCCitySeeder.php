<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateAGCCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 282,
'name' => 'Agdzhabedy'
],[
'state_id' => 282,
'name' => 'Avşar'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
