<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ECStatePCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1150,
'name' => 'Cayambe'
],[
'state_id' => 1150,
'name' => 'Machachi'
],[
'state_id' => 1150,
'name' => 'Quito'
],[
'state_id' => 1150,
'name' => 'Sangolquí'
],[
'state_id' => 1150,
'name' => 'Tutamandahostel'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
