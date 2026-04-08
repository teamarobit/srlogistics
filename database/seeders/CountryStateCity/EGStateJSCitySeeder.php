<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateJSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1167,
'name' => 'Dahab'
],[
'state_id' => 1167,
'name' => 'El-Tor'
],[
'state_id' => 1167,
'name' => 'Nuwaybi‘a'
],[
'state_id' => 1167,
'name' => 'Saint Catherine'
],[
'state_id' => 1167,
'name' => 'Sharm el-Sheikh'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
