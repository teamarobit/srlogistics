<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GYStateMACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1575,
'name' => 'Mahaicony Village'
],[
'state_id' => 1575,
'name' => 'Rosignol'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
