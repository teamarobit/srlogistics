<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TDStateODCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 757,
'name' => 'Abéché'
],[
'state_id' => 757,
'name' => 'Adré'
],[
'state_id' => 757,
'name' => 'Goz Béïda'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
