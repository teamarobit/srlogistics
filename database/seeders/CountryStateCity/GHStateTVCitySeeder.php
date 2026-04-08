<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GHStateTVCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1448,
'name' => 'Aflao'
],[
'state_id' => 1448,
'name' => 'Anloga'
],[
'state_id' => 1448,
'name' => 'Ho'
],[
'state_id' => 1448,
'name' => 'Hohoe'
],[
'state_id' => 1448,
'name' => 'Keta'
],[
'state_id' => 1448,
'name' => 'Kete Krachi'
],[
'state_id' => 1448,
'name' => 'Kpandu'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
