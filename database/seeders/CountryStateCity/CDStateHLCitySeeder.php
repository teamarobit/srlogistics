<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CDStateHLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 890,
'name' => 'Bukama'
],[
'state_id' => 890,
'name' => 'Kamina'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
