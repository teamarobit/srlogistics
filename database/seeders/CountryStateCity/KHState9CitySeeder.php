<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState9CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 668,
'name' => 'Koh Kong'
],[
'state_id' => 668,
'name' => 'Smach Mean Chey'
],[
'state_id' => 668,
'name' => 'Srae Ambel'
],[
'state_id' => 668,
'name' => 'Srŏk Batum Sakôr'
],[
'state_id' => 668,
'name' => 'Srŏk Môndôl Seima'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
