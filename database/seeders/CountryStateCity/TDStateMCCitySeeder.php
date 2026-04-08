<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TDStateMCCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 746,
'name' => 'Kyabé'
],[
'state_id' => 746,
'name' => 'Sarh'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
