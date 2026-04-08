<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BNStateBMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 551,
'name' => 'Bandar Seri Begawan'
],[
'state_id' => 551,
'name' => 'Berakas A'
],[
'state_id' => 551,
'name' => 'Kapok'
],[
'state_id' => 551,
'name' => 'Mentiri'
],[
'state_id' => 551,
'name' => 'Serasa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
