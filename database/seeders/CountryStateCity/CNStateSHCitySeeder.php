<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateSHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 787,
'name' => 'Shanghai'
],[
'state_id' => 787,
'name' => 'Songjiang'
],[
'state_id' => 787,
'name' => 'Zhabei'
],[
'state_id' => 787,
'name' => 'Zhujiajiao'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
