<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AOStateBGUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 152,
'name' => 'Benguela'
],[
'state_id' => 152,
'name' => 'Catumbela'
],[
'state_id' => 152,
'name' => 'Lobito'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
