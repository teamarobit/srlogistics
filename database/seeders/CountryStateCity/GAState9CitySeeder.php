<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GAState9CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1395,
'name' => 'Bitam'
],[
'state_id' => 1395,
'name' => 'Mitzic'
],[
'state_id' => 1395,
'name' => 'Oyem'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
