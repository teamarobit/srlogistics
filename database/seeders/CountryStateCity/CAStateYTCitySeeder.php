<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CAStateYTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 696,
'name' => 'Dawson City'
],[
'state_id' => 696,
'name' => 'Haines Junction'
],[
'state_id' => 696,
'name' => 'Watson Lake'
],[
'state_id' => 696,
'name' => 'Whitehorse'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
