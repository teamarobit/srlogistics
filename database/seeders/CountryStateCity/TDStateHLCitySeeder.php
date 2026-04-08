<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TDStateHLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 749,
'name' => 'Bokoro'
],[
'state_id' => 749,
'name' => 'Massaguet'
],[
'state_id' => 749,
'name' => 'Massakory'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
